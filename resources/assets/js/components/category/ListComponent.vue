<template>
 <div class="col-lg-12">
    <h4 class="m-t-0 header-title"><b>Danh sách loại tin</b></h4>
    <div class="row m-t-20">
        <div class="col-md-8">
            <button type="button" class="btn btn-success btn-sm" @click="showModal('create', {})"><i class="fa fa-plus"></i> Thêm</button>
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
                        <th>Tên loại tin</th>
                        <th>Trạng thái</th>
                        <th>Số bài viết</th>
                        <th class="created_at">Tạo lúc</th>
                        <th class="action-4"></th>
                    </tr>
                </thead>
                <tbody>
                    <template v-if="pages > 0">
                       <tr v-for="(category, index) in categories" :key="index">
                            <td v-html="index + 1"></td>
                            <td v-html="category.name"></td>
                            <td v-html="getStatus(category.status)"></td>
                            <td v-html="totalNews(category.news)"></td>
                            <td v-html="category.created_at"></td>
                            <td class="text-center">
                                <button type="button" class="btn btn-success btn-sm" @click="showModal('view', category)"><i class="fa fa-eye"></i></button>
                                <button type="button" class="btn btn-primary btn-sm" @click="showModal('edit', category)"><i class="fa fa-edit"></i></button>
                                <button type="button" class="btn btn-danger btn-sm" @click="deleteItem(category)"><i class="fa fa-trash"></i></button>
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
            <Modal :passAction="action"
                   :passCategory="passCategory"
                   @updateList="updateList"/>
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
            categories: {},
            pages: 0,
            currentPage: 1,
            action: 'create',
            passCategory: {},
        }
    },
    created() {
        this.fetchData();
    },
    methods: {
        fetchData: function(page = 1) {
            const that = this;
            that.currentPage = page;
            axios.get('/admin/api/category?page=' + page).then(function(res) {
                that.categories = res.data.items;
                that.pages = res.data.pages;
            });
        },
        clickCallBack: function(page) {
            this.fetchData(page);
        },
        deleteItem: function(category) {
            const that = this;
            swal({
                title: "Bạn chắc chắn chứ?",
                text: "Loại tin " + category.name + " sẽ bị xóa khi bạn chấp nhận!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    axios.delete(`/admin/api/category/${category.id}`).then(function(res) {
                        $('#lessonModal').modal('hide');
                        if(res.code === 200) {
                            swal({
                                title: 'Thành công!',
                                html: `Bạn đã xoá loại tin <b>${category.name}</b> thành công!`,
                                icon: 'success'
                            });
                            that.categories = res.data.items;
                        }
                    });
                }
            });
        },

        showModal(action, category) {
            this.action = action;
            this.passCategory = category
            $('#lessonModal').modal();
        },
        updateList(payload) {
            this.categories = payload;
        },
        search(value) {
            const that = this;
            axios.get(`/admin/api/category?search=${value}`).then(function(res) {
                that.categories = res.data.items;
                that.pages = res.data.pages;
            })
        },
        getStatus(value){

            let status = '<i class="fa fa-circle text-danger mr-2"></i> Đang khóa';

            if(value === '1'){
                status = '<i class="fa fa-circle text-success mr-2"></i> Đã kích hoạt';
            }

            return status;
        },
        totalNews(value){
            let total_news = 0;

            if (value){
                total_news = value.length;
            }

            return total_news;
        }
    }
}
</script>
