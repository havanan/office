<template>
 <div class="col-lg-12">
    <h4 class="m-t-0 header-title"><b>Danh sách</b></h4>
        <div class="row m-t-20">
        <div class="col-md-9">
        </div>
        <div class="col-md-3">
            <input type="text" placeholder="Tìm kiếm..." class="form-control input-sm" v-model="strSearch" @keypress.enter="search">
        </div>
    </div>
    <div class="m-t-20">
        <div class="table-responsive">
            <table class="table m-0 table-bordered table-hover table-reponsive">
                <thead>
                    <tr>
                        <th class="order text-center">#</th>
                        <th class="w-150p">Email</th>
                        <th>Nội dung</th>
                        <th class="w-150p text-center">Ngày tạo</th>
                        <th class="w-150p text-center">Trả lời</th>

                    </tr>
                </thead>
                <tbody>
                    <template v-if="pages > 0">
                        <tr v-for="(course, index) in courses" :key="index" class="pointer">
                            <td v-html="getOrderNumber(currentPage, index)"></td>
                            <td v-html="course.email" class="text-primary"></td>
                            <td>
                                <p class="text-danger"><strong v-html="course.name"></strong></p>
                                <p> <strong  v-html="course.content"></strong></p>
                            </td>
                            <td v-html="course.created_at" class="text-center"></td>
                            <td class="text-center"><input type="checkbox" @click="changeStatus(course)" v-model="course.status"></td>
                        </tr>
                    </template>
                    <template v-else>
                        <tr><td colspan="10" class="text-center">Không có dữ liệu</td></tr>
                    </template>
                </tbody>
            </table>
            <paginate
                v-model="currentPage"
                v-if="pages > 1"
                :page-count="pages"
                :click-handler="clickCallBack"
                :prev-text="'Sau'"
                :next-text="'Trước'"
                :container-class="'pagination'">
            </paginate>
        </div>
    </div>
</div>
</template>
<script>
import Modal from '../common/Modal';
export default {
    components: {
        Modal,
    },
    data() {
        return {
            courses: {},
            pages: 0,
            currentPage: 1,
            action: 'create',
            strSearch: '',
            showModal: false,
        }
    },
    created() {
        this.fetchData();
    },
    methods: {
        fetchData: function(page = 1) {
            const that = this;
            that.currentPage = page;
            axios.get('/admin/api/feedback?page=' + page).then(function(res) {
                that.pages = res.pages
                that.courses = res.items;
            });
        },
        clickCallBack: function(page) {
            this.currentPage = page;
            this.fetchData(page);
        },
        deleteItem: function(course) {
            const that = this;
            swal({
                title: "Bạn chắc chắn chứ?",
                text: "Bình luận " + course.name + " sẽ bị xóa khi bạn chấp nhận!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    axios.delete(`/admin/api/course/${course.id}`).then(function(res) {
                        if(res.code === 200) {
                            swal({
                                title: 'Thành công!',
                                html: `Bạn đã xoá khoá học <b>${course.name}</b> thành công!`,
                                icon: 'success'
                            });
                            that.search();
                        }
                    });
                }
            });
        },
        search() {
            const that = this;
            that.isLoading = true
            const url = `/admin/api/feedback?search=${that.strSearch}`;
            axios.get(url).then(function(res) {
                that.courses = res.items;
                that.isLoading = false
            })
        },
        closeModal(value) {
            this.showModal = value
        },
        changeStatus(data){
            axios.get('/admin/api/feedback/status/' + data.id).then(res => {
                swal({
                    title: 'Thành công!',
                    html: `Bạn đã trả lời feedback <b>${data.title}</b> thành công!`,
                    icon: 'success'
                });
                this.fetchData( this.currentPage);
            }).catch(err => {
                swal({
                    title: 'Lỗi!',
                    html: `Vui lòng thử lại`,
                    icon: 'error'
                });
            });
        }
    },
}
</script>
<style>

</style>
