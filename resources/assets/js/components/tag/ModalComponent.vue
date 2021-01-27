<template>
  <div class="modal fade" id="lessonModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Thông tin thẻ tag</h4>
        </div>
         <form class="form-horizontal form-label-left" @submit.prevent="onSubmit">
                <div class="modal-body">
                    <div class="col-md-12 center-margin">
                    <div class="form-group">
                        <label>Tên thẻ tag</label>
                        <input  class="form-control" v-model="formData.name" name="name" required :disabled="action === 'view'" />
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
            tag: this.passTag,
            formData: {
                name:'',
            },
        }
    },
    props: ['passAction', 'passTag'],
    watch: {
        passAction: function(value) {
            this.action = value
        },
        passTag: function(value) {
            this.formData.name     = value.name;
            this.tag          = value;
        }
    },
    methods: {
        onSubmit: function() {
            const that = this;
            switch(that.action) {
                case 'create':
                    axios.post('/admin/api/tag', that.formData)
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
                                    html: `Bạn đã tạo thẻ tag <b>${that.formData.name}</b> thành công!`,
                                    icon: 'success'
                                });
                                $('#lessonModal').modal('hide');
                                that.$emit('updateList', res.data.items);
                            }else {
                                swal({
                                    title: 'Lỗi!',
                                    text: 'Tạo thẻ tag thất bại!',
                                    icon: 'error'
                                });
                                $('#lessonModal').modal('hide');
                            }
                        }
                    );
                    break;
                case 'edit':
                    axios.put(`/admin/api/tag/${that.tag.id}`, that.formData).then(function(res) {
                        $('#lessonModal').modal('hide');
                        if(res.code === 200) {
                            swal({
                                title: 'Thành công!',
                                html: `Bạn đã sửa thẻ tag <b>${that.formData.name}</b> thành công!`,
                                icon: 'success'
                            });
                            that.$emit('updateList', res.data.items);
                        }
                    });
                    break;
                default:
                    swal({
                        title: "Bạn chắc chắn chứ?",
                        html: `Bạn sẽ xoá thẻ tag <i>${that.formData.name}</i>`,
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

        }
    }
}
</script>
