<template>
 <div class="col-lg-12">
    <h4 class="m-t-0 header-title"><b>Danh sách tin tức</b></h4>
    <div class="row m-t-20">
        <div class="col-md-2">
            <a href="news/create"  class="btn btn-success btn-sm" ><i class="fa fa-plus"></i> Thêm</a>
        </div>

        <div class="col-md-10">
            <div class="row">
                <div class="col-md-3">

                </div>
                <div class="col-md-3">
                    <select class="form-control" name="is_publish" id="is_publish" v-model="formData.is_publish" v-on:change="findNews()">
                        <option value="">Tất cả trạng thái</option>
                        <option v-for="(status,index) in publicStatus" :value="index" v-html="status"></option>
                    </select>
                </div>
                <div class="col-md-3">
                    <multiselect v-model="formData.categories"
                                 :options="categories"
                                 :multiple="true"
                                 :close-on-select="true"
                                 :clear-on-select="true"
                                 :preserve-search="true"
                                 :preselect-first="false"
                                 label="name" track-by="id"
                                 @input="findNews"
                                 placeholder="Chọn một hoặc nhiều chuyên mục">
                    </multiselect>
                </div>
                <div class="col-md-3">
                    <div clas="form-group">
                        <input type="text" placeholder="Tìm kiếm..." class="form-control" v-on:change="search($event.target.value)">
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="m-t-20">
        <div class="table-responsive">
            <table class="table table-bordered m-0 ">
                    <thead>
                    <tr>
                        <th class="order text-center">#</th>
                        <th></th>
                        <th>Tiêu đề</th>
                        <th>Tag</th>
                        <th>Loại tin</th>
                        <th>Tác giả</th>
                        <th>Trạng thái</th>
                        <th class="created_at">Tạo lúc</th>
                        <th class="action-4"></th>
                    </tr>
                </thead>
                <tbody>
                    <template v-if="pages > 0">
                       <tr v-for="(news, index) in newsGr" :key="index">
                            <td v-html="index + 1"></td>
                            <td v-html="getImage(news.image)"></td>
                            <td v-html="getTitle(news.title)"></td>
                            <td v-html="getNewsTags(news.tags)"></td>
                            <td v-html="getNewsCategories(news.categories)"></td>
                            <td v-html="getNewsAuthor(news.author)"></td>
                            <td v-html="getNewsStatus(news.is_publish)"></td>
                            <td v-html="news.created_at"></td>
                            <td class="text-center">
                                <button type="button" class="btn btn-success btn-sm" @click="showModal('view', news)"><i class="fa fa-eye"></i></button>
                                <button type="button" class="btn btn-primary btn-sm" @click="edit(news)"><i class="fa fa-edit"></i></button>
                                <button type="button" class="btn btn-danger btn-sm" @click="deleteItem(news)"><i class="fa fa-trash"></i></button>
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
                   :passNews="passNews"
                   @updateList="updateList"/>
        </div>
    </div>
</div>
</template>
<script>
import Modal from './ModalComponent';
import Multiselect from 'vue-multiselect';

export default {
    components: {
        Modal,
        Multiselect
    },
    data() {
        return {
            newsGr: {},
            pages: 0,
            currentPage: 1,
            action: 'create',
            passNews: {},
            formData:{
                categories:[],
                is_publish:''
            },
            categories:categories,
            publicStatus:publicStatus,
        }
    },
    created() {
        this.fetchData();
    },
    methods: {
        fetchData: function(page = 1) {
            const that = this;
            that.currentPage = page;
            axios.get('/admin/api/news?page=' + page).then(function(res) {
                that.newsGr = res.data.items;
                that.pages = res.data.pages;
            });
        },
        clickCallBack: function(page) {
            this.fetchData(page);
        },
        deleteItem: function(news) {
            const that = this;
            swal({
                title: "Bạn chắc chắn chứ?",
                text: "Loại tin " + news.name + " sẽ bị xóa khi bạn chấp nhận!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    axios.delete(`/admin/api/news/${news.id}`).then(function(res) {
                        $('#lessonModal').modal('hide');
                        if(res.code === 200) {
                            swal({
                                title: 'Thành công!',
                                html: `Bạn đã xoá tin tức <b>${news.name}</b> thành công!`,
                                icon: 'success'
                            });
                            that.newsGr = res.data.items;
                        }
                    });
                }
            });
        },

        showModal(action, news) {
            this.action = action;
            this.passNews = news
            $('#lessonModal').modal();
        },
        updateList(payload) {
            this.newsGr = payload;
        },
        search(value) {
            const that = this;
            axios.get(`/admin/api/news?search=${value}`).then(function(res) {
                that.newsGr = res.data.items;
                that.pages = res.data.pages;
            })
        },
        getStatus:function(value){

            let status = '<i class="fa fa-circle text-danger mr-2"></i> Ẩn';

            if(value === 1){
                status = '<i class="fa fa-circle text-success mr-2"></i> Hiển thị';
            };

            return status;
        },
        getImage:function(value){
            let imagePath = '/storage/admin/images/no_image.png';

            if (value){
                imagePath = value;
            }

            return '<img class="thumb-lg" src="'+imagePath+'">';
        },
        getTitle:function(value){

            if(value){

                return '<a href="#" target="_blank">'+value+'</a>'

            }
        },
        getAuthor:function(value){
            let result = '';

            if (value && value.fullname){

                result = '<a href="'+value.id+'" target="_blank">'+value.fullname+'</a>';

            }
            return result;
        },
        findNews:function () {
                let frm = this.formData;
                let is_publish = frm.is_publish;
                let categories = frm.categories;
                let catGr = [];
                let that = this;

                if (categories.length > 0){
                        for (let i = 0; i< categories.length; i++){
                            if (categories[i].id){
                                catGr.push(categories[i].id)
                            }
                        }
                }
                let url = '/admin/api/news?search=&is_publish=' + is_publish+'&categories='+JSON.stringify(catGr);

                axios.get(url).then(function(res) {
                    that.newsGr = res.data.items;
                    that.pages = res.data.pages;
                });
        },
        edit:function(news) {
            if(!news.id){
                return false;
            }

            let newId = news.id;

            let url = '/news/edit/'+newId;

            window.location.href = url;
        }
    }
}
</script>
