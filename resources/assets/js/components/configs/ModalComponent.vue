<template>
  <div class="modal fade" id="lessonModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Thông tin cài đặt</h4>
        </div>
         <form class="form-horizontal form-label-left" @submit.prevent="onSubmit" >
                <div class="modal-body">
                    <div class="col-md-12 center-margin">
                        <div class="form-group">
                            <label>Tên cài đặt</label>
                            <input  class="form-control" v-model="formData.key" name="key" required :disabled="action === 'view'" />
                        </div>
                    </div>
                    <div class="col-md-12 center-margin">
                        <div class="form-group">
                            <label>Trạng thái</label>
                            <select class="form-control" v-model="formData.status" name="status" required :disabled="action === 'view'" >
                                <option value="0">Hiển thị</option>
                                <option value="1">Ẩn</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12 center-margin">
                        <div class="form-group">
                            <label>Loại</label>
                            <select class="form-control" v-model="formData.type" name="type" required :disabled="action === 'view'" @change="changeType($event.target.value)" >
                                <option value="text">Chữ</option>
                                <option value="img">Ảnh</option>
                            </select>
                        </div>
                        <div class="form-group" v-if="formData.type === 'text'">
                            <label>Nội dung</label>
                            <input  class="form-control" v-model="formData.value" name="value" required :disabled="action === 'view'" />
                        </div>
                        <div class="form-group" v-else>
                            <div class="row">
                                <div class="col-lg-4">
                        <label class="control-label">Ảnh bìa</label>
                        <div class="input-group m-t-10">
                           <span class="input-group-btn">
                             <button type="button" id="akk" data-input="thumbnail" class="btn btn-primary" @click="standAloneBtn">
                               <i class="fa fa-picture-o"></i> Chọn ảnh
                             </button>
                               <br>
                               <a id="del" class="btn btn-danger m-t-10" @click="removeImageForm">
                               <i class="fa fa-trash-o m-r-10"></i> Xóa ảnh
                             </a>
                           </span>
                            <input id="thumbnail" class="form-control" type="text" name="images" style="display:none" v-model="formData.value">
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="form-group">
                            <img id="holder" style="margin-top:15px;width: 100%;" :src="action === 'edit' ? formData.value : imagePath" />
                        </div>
                    </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 center-margin">
                        <div class="form-group">
                            <label>Json</label>
                            <textarea class="form-control" v-model="formData.json" name="json" required :disabled="action === 'view'">{{formData.json}}</textarea>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Huỷ</button>
                <button type="submit" class="btn btn-primary" v-if="action === 'edit' || action === 'create'">Xử lý</button>
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
            config: this.passConfig,
            imagePath:'/storage/admin/images/no_image.png',
            formData: {
                key:'',
                type:'text',
                status:0,
                value:'',
                json:''
            },
        }
    },
    props: ['passAction', 'passConfig'],
    watch: {
        passAction: function(value) {
            this.action = value
        },
        passConfig: function(value) {
            this.formData.key      = value.key;
            this.formData.type     = value.type;
            this.formData.status   = value.status;
            this.formData.value    = value.value;
            this.formData.json     = value.json;
            this.config            = value;
        }
    },
    methods: {
        onSubmit: function() {
            const that = this;
            if(that.formData.type === 'img'){
                that.formData.value = $('#thumbnail').val();
            }
            switch(that.action) {
                case 'create':
                    axios.post('/admin/api/config/', that.formData)
                        .catch(function (error) {
                            if (error.response) {
                                // Request made and server responded
                                let err_message = 'Vui lòng thử lại !';
                                swal({
                                    title: 'Lỗi!',
                                    text: err_message,
                                    icon: 'error'
                                });
                                $('#lessonModal').modal('hide');
                                // console.log(error.response.status);
                            }
                        })
                        .then(function(res) {
                            if (res.code && res.code === 200) {
                                swal({
                                    title: 'Thành công!',
                                    html: `Bạn đã tạo cài đặt <b>${that.formData.key}</b> thành công!`,
                                    icon: 'success'
                                });
                                $('#lessonModal').modal('hide');
                                that.$emit('updateList', res.data.items);
                            }else {
                                swal({
                                    title: 'Lỗi!',
                                    text: 'Tạo người dùng thất bại!',
                                    icon: 'error'
                                });
                                $('#lessonModal').modal('hide');
                            }
                        }
                    );
                    break;
                case 'edit':
                    axios.put(`/admin/api/config/${that.config.id}`, that.formData).then(function(res) {
                        $('#lessonModal').modal('hide');
                        if(res.code === 200) {
                            swal({
                                title: 'Thành công!',
                                html: `Bạn đã sửa cài đặt <b>${that.formData.key}</b> thành công!`,
                                icon: 'success'
                            });
                            that.$emit('updateList', res.data.items);
                        }
                    });
                    break;
                default:
                    swal({
                        title: "Bạn chắc chắn chứ?",
                        html: `Bạn sẽ xoá cài đặt <i>${that.formData.key}</i>`,
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {

                        }
                    });
                    break;
            }

        },
        changeType:function(value){
            if(value === 'img'){
                    this.standAloneBtn();
            }
        },
        standAloneBtn:function(){
             $('#akk').filemanager('image');
        },
        removeImageForm:function(){
              this.formData.value = '';
              this.imagePath = '/storage/admin/images/no_image.png';
            },
             getImageFormPreview : function () {
                const imagePath = $('#thumbnail').val();
                if (imagePath){
                    this.imagePath =  imagePath;
                    this.formData.value = imagePath;
                }
            },
    },
    mounted(){

    }
}
</script>
