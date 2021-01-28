<template>

    <form id="frm" method="post" @submit="checkForm"  @mouseover="getImageFormPreview">
        <div class="col-md-3">
            <div class="card-box" >

                <h4 class="m-t-0 m-b-20 header-title">Đa phương tiện</h4>
                <div class="row">
                    <div class="col-lg-4">
                        <label class="control-label">Ảnh bìa</label>
                        <div class="input-group m-t-10">
                           <span class="input-group-btn">
                             <a id="lfm" data-input="thumbnail" class="btn btn-primary">
                               <i class="fa fa-picture-o"></i> Chọn ảnh
                             </a>
                               <br>
                               <a id="del" class="btn btn-danger m-t-10" v-on:click="removeImageForm">
                               <i class="fa fa-trash-o m-r-10"></i> Xóa ảnh
                             </a>
                           </span>
                            <input id="thumbnail" class="form-control" type="text" name="images" style="display:none" v-model="formData.images">
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="form-group">
                            <img id="holder" style="margin-top:15px;width: 100%;" :src="imagePath" />
                        </div>
                    </div>

                </div>
            </div>
            <div class="card-box">
                <h4 class="m-t-0 m-b-20 header-title">Chuyên mục tin</h4>
                <div class="row">
                    <div class="col-lg-12">

                        <div class="form-group">
                            <multiselect v-model="formData.categories"
                                         :options="categories"
                                         :multiple="true"
                                         :close-on-select="true"
                                         :clear-on-select="true"
                                         :preserve-search="true"
                                         :preselect-first="false"
                                         label="name" track-by="id"
                                         :custom-label="customLabel"
                                         placeholder="Chọn một hoặc nhiều chuyên mục">
                            </multiselect>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-box">
                <h4 class="m-t-0 m-b-20 header-title">Thẻ Tags</h4>
                <div class="row">
                    <div class="col-lg-12">

                        <div class="form-group">
                            <tags-input element-id="tags"
                                        v-model="formData.tags"
                                        :existing-tags="tagsGr"
                                        :typeahead="true"
                                        :placeholder="'Nhập một hoặc nhiều thẻ tag'"
                            ></tags-input>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-box">
                <h4 class="m-t-0 m-b-20 header-title">Trạng thái</h4>
                <div class="row">
                    <div class="col-lg-12">

                        <div class="form-group">
                            <select class="form-control" name="is_publish" id="is_publish" v-model="formData.is_publish">
                                <option v-for="(status,index) in publicStatus" :value="index" v-html="status"></option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card-box">
                <h4 class="m-t-0 m-b-20 header-title">Nội dung bài viết</h4>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="control-label">Tiêu đề <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="title" v-model="formData.title" id="title">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Tóm tắt <span class="text-danger">*</span></label>
                            <textarea class="form-control editor" rows="9" v-model="formData.description" name="description" id="description"></textarea>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Nội dung <span class="text-danger">*</span></label>
                            <textarea class="form-control editor" v-model="formData.content" name="content" rows="18" id="content"></textarea>
                        </div>
                        <div class="form-group">
                            <div class="text-right">
                                <button type="reset" class="btn btn-danger m-r-5" v-on:click="clearForm"><i class="fa fa-recycle m-r-5"></i>Nhập lại</button>
                                <button type="submit" class="btn btn-primary m-r-5"><i class="fa fa-save m-r-5"></i>Lưu</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <p v-if="errors.length">
                    <b>Vui lòng kiểm tra lại các lỗi:</b>
                <ul>
                    <li v-for="error in errors" class="text-danger">{{ error }}</li>
                </ul>
                </p>
            </div>
            <div class="form-group">
                <div class="text-left">
                    <button type="reset" class="btn btn-danger m-r-5" v-on:click="clearForm"><i class="fa fa-recycle m-r-5"></i>Nhập lại</button>
                    <button type="submit" class="btn btn-primary m-r-5"><i class="fa fa-save m-r-5"></i>Lưu</button>
                </div>
            </div>
        </div>

    </form>
</template>

<script>
    import TagsInput from '@voerro/vue-tagsinput';
    import Multiselect from 'vue-multiselect';

    export default {
        components: {
            TagsInput,
            Multiselect
        },
        data() {
            return {
                formData: {
                    images:'',
                    title:'',
                    description:'',
                    content:'',
                    is_publish:1,
                    categories:[],
                    tags:[]
                },
                categories:categories,
                publicStatus:publicStatus,
                tagsGr:[],
                value: [],
                errors: [],
                timeRedirect:2000,
                imagePath:'/storage/admin/images/no_image.png',
                action:'create',
                homePageUrl:'/news',
                newsId: newsId,
            }
        },
        methods:{
            onSubmit : function (frm) {

                let that = this;

                switch (that.action){

                    case 'create':
                        axios.post('/news/create',frm).then(function(res) {
                            swal({
                                title: 'Thành công!',
                                text: 'Bạn đã đăng bài thành công!',
                                icon: 'success'
                            }).then(function(){
                                window.location.href = that.homePageUrl;
                            });
                        }).catch(error => {

                            swal({
                                title: 'Lỗi!',
                                text: `Vui lòng kiểm tra lại các trường vừa nhập`,
                                icon: 'error'
                            });
                        });
                        break;
                    case 'edit':
                        axios.put(`/news/update/${that.newsId}`,frm).then(function(res) {

                            swal({
                                title: 'Thành công!',
                                text: 'Bạn đã cập nhật bài thành công!',
                                icon: 'success'
                            }).then(function(){
                                window.location.href = that.homePageUrl;
                            });
                        }).catch(error => {

                            swal({
                                title: 'Lỗi!',
                                text: `Vui lòng kiểm tra lại các trường vừa nhập`,
                                icon: 'error'
                            });
                        });
                        break;
                }
            },
            checkForm : function(e){
                let that = this;
                const frm = that.formData;

                frm.content = tinyMCE.get('content').getContent();
                frm.description = tinyMCE.get('description').getContent();

                this.errors = [];

                if (!frm.title) {
                    this.errors.push('Tiêu đề không được để trống.');
                }
                if (frm.categories.length <= 0) {
                    this.errors.push('Chuyên mục không được để trống.');
                }
                if (!frm.description) {
                    this.errors.push('Tóm tắt không được để trống.');
                }
                if (!frm.content) {
                    this.errors.push('Nội dung không được để trống.');
                }

                e.preventDefault();

                if (frm.title  && frm.description && frm.content && frm.categories.length > 0) {
                    if(that.newsId){
                        that.action = 'edit';
                    }
                    this.onSubmit(frm);

                }

            },
            findTags : function(value){
                const that = this;
                const link = '/admin/api/tag/find';
                if(value){
                    link +='?search='+value;
                }
                axios.get(link).then(function(res) {
                    that.tagsGr = res.data;
                })

            },
            setSelectedTags : function() {
                const selectedItem = { key: 'php', value: 'PHP' };
                this.selectedTags = [];
            },
            initFileManager:function(){
                this.$nextTick(function() {
                    $('#lfm').filemanager('image');
                });
            },
            redirectHome : function(time = false){
                if (!time){
                    time = 3000;
                }
                setTimeout(function(){
                    window.location.href = this.homePageUrl;
                }, time);
            },
            getImageFormPreview : function () {
                const imagePath = $('#thumbnail').val();
                if (imagePath){
                    this.imagePath =  imagePath;
                    this.formData.images = imagePath;
                }
            },
            customLabel : function ({ name }) {
                return `${name}`
            },
            clearForm : function () {

                this.formData = {
                    images:'',
                    title:'',
                    description:'',
                    content:'',
                    is_publish:1,
                    categories:[],
                    tags:[]
                }

                this.removeImageForm();
            },
            findNewsInfo : function(){
                let that = this;
                if(!this.newsId){

                    return false;
                }

                axios.get('/admin/api/news/find',{
                    params:{
                        id:this.newsId
                    }
                }).then(function(res) {
                    if(!res.data) {

                        return false;

                    }

                    const data = res.data;

                    that.formData = {
                        title:data.title,
                        images:data.image,
                        description:that.htmlDecode(data.description),
                        content:that.htmlDecode(data.content),
                        is_publish:data.is_publish,
                        categories:that.getCategories(data),
                        tags: that.getTags(data)
                    };
                });
            },
            getCategories : function(data){
                let categories = [];

                if(data.categories && data.categories.length > 0 ){
                    for(let i = 0; i < data.categories.length; i++ ){

                        if(data.categories[i].category_info && data.categories[i].category_info.name){
                            let item = {
                                id:data.categories[i].category_id,
                                name:data.categories[i].category_info.name
                            }
                            categories.push(item);
                        }
                    }
                }
                return categories;
            },
            getTags : function(data){
                let tags = [];
                if(data.tags && data.tags.length > 0 ){
                    for(let i = 0; i < data.tags.length; i++ ){

                        if(data.tags[i].tag_info && data.tags[i].tag_info.name){
                            let tag = {
                                key:data.tags[i].tag_id,
                                value:data.tags[i].tag_info.name
                            }
                            tags.push(tag);
                        }
                    }
                }
                return tags;
            }

        },
        mounted() {

            this.findTags();
            this.initFileManager();
            this.findNewsInfo();

        }
    }
</script>
