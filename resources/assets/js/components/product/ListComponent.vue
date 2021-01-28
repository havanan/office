<template>
 <div class="col-lg-12">
    <h4 class="m-t-0 header-title"><b>Cài đặt hệ thống</b></h4>
    <div class="row m-t-20">
        <div class="col-md-8">
            <!-- <button type="button" class="btn btn-success btn-sm" @click="showModal('create', {status:0,type:'text'})"><i class="fa fa-plus"></i> Thêm</button> -->
        </div>
        <div class="col-md-4">
            <input type="text" placeholder="Tìm kiếm..." class="form-control input-sm" v-on:change="search($event.target.value)">
        </div>
    </div>

    <div class="m-t-20">
        <div class="table-responsive">
            <table class="table table-bordered m-0 ">
                    <thead>
                    <tr>
                        <th class="order text-center">#</th>
                        <th>Tên</th>
                        <th>Giá trị</th>
                         <th>Loại</th>
                        <th>Trạng thái</th>
                        <th class="created_at">Tạo lúc</th>
                        <th class="action-3"></th>
                    </tr>
                </thead>
                <tbody>
                    <template v-if="pages > 0">
                       <tr v-for="(config, index) in configs" :key="index">
                            <td v-html="index + 1"></td>
                            <td v-html="config.key"></td>
                            <td v-html="getValue(config)"></td>
                            <td v-html="getType(config.type)"></td>
                            <td v-html="getStatus(config.status)"></td>
                            <td v-html="config.created_at"></td>
                            <td class="text-center">
                                <!-- <button type="button" class="btn btn-success btn-sm" @click="showModal('view', config)"><i class="fa fa-eye"></i></button> -->
                                <button type="button" class="btn btn-primary btn-sm" @click="showModal('edit', config)"><i class="fa fa-edit"></i></button>
                                <!-- <button type="button" class="btn btn-danger btn-sm" @click="deleteItem(config)"><i class="fa fa-trash"></i></button> -->
                            </td>
                        </tr>
                    </template>
                    <template v-else>
                        <tr><td class="text-center" colspan="11">Không có dữ liệu</td></tr>
                    </template>

                </tbody>
            </table>
            <paginate
                v-if="pages > 1"
                :page-count="pages"
                :click-handler="clickCallBack"
                :prev-text="'Sau'"
                :next-text="'Trước'"
                :container-class="'pagination'">
            </paginate>
            <Modal :passAction="action" :passConfig="passConfig" @updateList="updateList"/>
        </div>
    </div>
</div>
</template>
<script>
import Modal from './ModalComponent';
export default {
    components: {
        Modal
    },
    data() {
        return {
            configs: {},
            pages: 0,
            currentPage: 1,
            action: 'create',
            imagePath:'/storage/admin/images/no_image.png',
            passConfig: {}
        }
    },

    created() {
        this.fetchData();
    },
    methods: {
        fetchData: function(page = 1) {
            const that = this;
            that.currentPage = page;
            axios.get('/admin/api/config?page=' + page).then(function(res) {
                that.configs = res.data.items;
                that.pages = res.data.pages;
            });
        },
        clickCallBack: function(page) {
            this.fetchData(page);
        },
        deleteItem: function(config) {
            const that = this;
            swal({
                title: "Bạn chắc chắn chứ?",
                text: "Cài đặt " + config.fullname + " sẽ bị xóa khi bạn chấp nhận!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    axios.delete(`/admin/api/config/${config.id}`).then(function(res) {
                        $('#lessonModal').modal('hide');
                        if(res.code === 200) {
                            swal({
                                title: 'Thành công!',
                                html: `Bạn đã xoá cài đặt <b>${config.fullname}</b> thành công!`,
                                icon: 'success'
                            });
                            that.configs = res.data.items;
                        }
                    });
                }
            });
        },

        showModal(action, config) {
            this.action = action;
            this.passConfig = config
            $('#lessonModal').modal();
        },
        updateList(payload) {
            this.configs = payload;
        },
        search(value) {
            const that = this;
            axios.get(`/admin/api/config?search=${value}`).then(function(res) {
                that.configs = res.data.items;
                that.pages = res.data.pages;
            })
        },
        getStatus(value){
            let status = '<i class="fa fa-circle text-success mr-2"></i> Hiện';
            if(value === 1){
                status = value = '<i class="fa fa-circle text-danger mr-2"></i> Ẩn';
            }
            return status;
        },
        getType(value){
            let type = 'Chữ';
            if(value === 'img'){
                type = 'Ảnh';
            }
            return type;
        },
        getValue(config){
            const type = config.type;
            let value = config.value;
            if(type === 'img'){
                if(!value){
                    value = this.imagePath;
                }
                value = '<img src="'+value+'" width="100px">';
            }
            return value;
        }
    }
}
</script>
