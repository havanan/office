<template>
  <div class="modal fade" id="lessonModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Thông tin tài khoản</h4>
        </div>
         <form class="form-horizontal form-label-left" @submit.prevent="onSubmit">
                <div class="modal-body">
                    <div class="col-md-12 center-margin">
                    <div class="form-group">
                        <label>Tên tài khoản</label>
                        <input  class="form-control" v-model="formData.fullname" name="fullname" required :disabled="action === 'view'" />
                        <label v-html="formError.fullname" class="text-danger"></label>
                    </div>
                </div>
                <div class="col-md-12 center-margin">
                    <div class="form-group">
                        <label>Email</label>
                        <input  class="form-control" v-model="formData.email" name="email" required :disabled="action === 'view'" />
                        <label v-html="formError.email" class="text-danger"></label>
                    </div>
                </div>
                    <div class="col-md-12 center-margin">
                        <div class="form-group">
                            <label>Di động</label>
                            <input  class="form-control" v-model="formData.mobile" name="mobile" required :disabled="action === 'view'" />
                            <label v-html="formError.mobile" class="text-danger"></label>
                        </div>
                    </div>
                    <div class="col-md-12 center-margin">
                        <div class="form-group">
                            <label>Trạng thái</label>
                            <select class="form-control" v-model="formData.status" name="status" required :disabled="action === 'view'" >
                                <option value="0">Đang khóa</option>
                                <option value="1">Đã kích hoạt</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12 center-margin">
                        <div class="form-group">
                            <label>Quyền</label>
                            <select class="form-control" v-model="formData.role_id" name="status" required :disabled="action === 'view'" >
                                <option value="0">Supper Admin</option>
                                <option value="1">Admin</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12 center-margin">
                        <div class="form-group">
                            <label>Giới tính</label>
                            <select class="form-control" v-model="formData.gender" name="gender" required :disabled="action === 'view'" >
                                <option value="male">Nam</option>
                                <option value="female">Nữ</option>
                            </select>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" @click="clearErrorForm()">Huỷ</button>
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
            customer: this.passCustomer,
            formData: {
                fullname:'',
                email:'',
                mobile:'',
                gender:'female',
                status:0,
                role_id:1
            },
            formError:{
                fullname:'',
                email:'',
                mobile:'',
            },
            formCheck:['fullname','email','mobile']
        }
    },
    props: ['passAction', 'passCustomer'],
    watch: {
        passAction: function(value) {
            this.action = value
        },
        passCustomer: function(value) {
            this.formData.email    = value.email;
            this.formData.mobile   = value.mobile;
            this.formData.status   = value.status;
            this.formData.gender   = value.gender;
            this.formData.fullname = value.fullname;
            this.formData.role_id = value.role_id;
            this.customer          = value;
        }
    },
    methods: {
        onSubmit: function() {
            const that = this;
            this.clearErrorForm();
            switch(that.action) {
                case 'create':
                    axios.post('/admin/api/user', that.formData)
                        .then(function(res) {
                                swal({
                                    title: 'Thành công!',
                                    html: `Bạn đã tạo tài khoản <b>${that.formData.fullname}</b> thành công!`,
                                    icon: 'success'
                                });
                                that.$emit('updateList', res.data.items);
                                $('#lessonModal').modal('hide');
                            })
                        .catch (response => {
                               const errors = response.response.data.errors;
                               this.showErrorForm(errors);
                            })
                    break;
                case 'edit':
                    axios.put(`/admin/api/user/${that.customer.id}`, that.formData)
                    .then(function(res) {
                        swal({
                                title: 'Thành công!',
                                html: `Bạn đã sửa tài khoản <b>${that.formData.fullname}</b> thành công!`,
                                icon: 'success'
                            });
                            that.$emit('updateList', res.data.items);
                        $('#lessonModal').modal('hide');
                    })
                    .catch (response => {
                               const errors = response.response.data.errors;
                               this.showErrorForm(errors);
                            })
                    break;
                default:
                    swal({
                        title: "Bạn chắc chắn chứ?",
                        html: `Bạn sẽ xoá tài khoản <i>${that.formData.fullname}</i>`,
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    break;
            }

        },
        clearErrorForm:function(){
            const that = this;
            const formCheck = this.formCheck;
            for(let i = 0;i < formCheck.length;i++){
                let item = formCheck[i];
                that.formError[item] = '';
            }
            return true;
        },
        showErrorForm:function(errors){

            const that = this;
            const formCheck = that.formCheck;
            const formError = that.formError;
            for(let i = 0;i < formCheck.length;i++){
                const key = that.formCheck[i];
                if(errors[key]){
                    const error = errors[key];
                    if(error.length > 0){
                       const  message = String(error)
                         formError[key] = message;
                     }
                 }
            }
            that.formError = formError;
        }

    }
}
</script>
