<template>
  <div class="modal fade" id="lessonModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Thông tin tin tức</h4>
        </div>
         <form class="form-horizontal form-label-left" @submit.prevent="onSubmit">
                <div class="modal-body">
                    <div class="col-md-12 center-margin">
                        
                    <div class="form-group">
                        <label>Tiêu đề</label>
                        <p v-html="news.title"></p>
                    </div>
                    <div class="form-group">
                        <img id="holder" style="margin-top:15px;width: 100%;" :src="news.image ? news.image : imagePath" />
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label>Trạng thái</label>
                                <p v-html="getNewsStatus(news.is_publish)"></p>
                            </div>
                            <div class="col-md-4">
                                <label>Tác giả</label>
                                <p v-html="getNewsAuthor(news.author)"></p>
                            </div>
                            <div class="col-md-4">
                                <label>Tạo lúc</label>
                                <p v-html="news.created_at"></p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Tóm tắt</label>
                        <p v-html="htmlDecode(news.description)"></p>
                    </div>
                     <div class="form-group">
                        <label>Nội dung</label>
                        <p v-html="htmlDecode(news.content)"></p>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Loại tin</label>
                                <p v-html="getNewsCategories(news.categories)"></p>
                            </div>
                             <div class="col-md-6">
                                 <label>Tag</label>
                                 <p v-html="getNewsTags(news.tags)"></p>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
            </div>
         </form>
        </div>
    </div>
 </div>
</template>
<script>
export default {
    data() {
        return {
            action: this.passAction,
            news: this.passNews,
            imagePath:'/storage/admin/images/no_image.png',
            formData: {
                name:'',
            },
        }
    },
    props: ['passAction', 'passNews'],
    watch: {
        passAction: function(value) {
            this.action = value
        },
        passNews: function(value) {
            console.log(value)
            this.news          = value;
        }
    },
    methods: {
       
    }
}
</script>
