<template>
    <div class="modal fade" id="lessonModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Thông tin loại sản phẩm</h4>
                </div>
                <form class="form-horizontal form-label-left" @submit.prevent="onSubmit">
                    <div class="modal-body">
                        <div class="col-md-12 center-margin">
                            <div class="form-group">
                                <label>Tên loại sản phẩm</label>
                                <input class="form-control" v-model="formData.name" name="name" required
                                       :disabled="action === 'view'"/>
                            </div>
                        </div>
                        <div class="col-md-12 center-margin">
                            <div class="form-group">
                                <label>Loại s/phẩm cha</label>
                                <select class="form-control" v-model="formData.parent_id" name="status" required
                                        :disabled="action === 'view'">
                                    <option value="0">---> Sp cha</option>
                                    <option v-for="(parent,index) in parentCat"
                                            :key="parent.id"
                                            :value="parent.id"
                                            v-html="parent.name">
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12 center-margin">
                            <div class="form-group">
                                <label>Trạng thái</label>
                                <select class="form-control" v-model="formData.status" name="status" required
                                        :disabled="action === 'view'">
                                    <option v-for="(status,index) in statusGr"
                                            :key="index"
                                            :value="index"
                                            v-html="status">
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Huỷ</button>
                        <button type="submit" class="btn btn-primary" v-if="action === 'edit' || action === 'create'">Xử
                            lý
                        </button>
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
                category: this.passCategory,
                formData: {
                    name: '',
                    parent_id:'',
                    status: this.defaultStatus
                },
                statusGr: statusGr,
                defaultStatus: 1
            }
        },
        props: ['passAction', 'passCategory','parentCat'],
        watch: {
            passAction: function (value) {
                this.action = value
            },
            passCategory: function (value) {
                this.formData.status = value.status ? value.status : this.defaultStatus;
                this.formData.parent_id = value.status ? value.parent_id : 0;
                this.formData.name = value.name;
                this.category = value;
            }
        },
        methods: {
            onSubmit: function () {
                const that = this;
                switch (that.action) {
                    case 'create':
                        axios.post('/mng/api/category', that.formData)
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
                            .then(function (res) {

                                    if (res.code && res.code === 200) {
                                        swal({
                                            title: 'Thành công!',
                                            html: `Bạn đã tạo loại tin <b>${that.formData.name}</b> thành công!`,
                                            icon: 'success'
                                        });
                                        $('#lessonModal').modal('hide');
                                        that.$emit('updateList', res.data.items);
                                    } else {
                                        swal({
                                            title: 'Lỗi!',
                                            text: 'Tạo loại tin thất bại!',
                                            icon: 'error'
                                        });
                                        $('#lessonModal').modal('hide');
                                    }
                                }
                            );
                        break;
                    case 'edit':
                        axios.put(`/mng/api/category/${that.category.id}`, that.formData).then(function (res) {
                            $('#lessonModal').modal('hide');
                            if (res.code === 200) {
                                swal({
                                    title: 'Thành công!',
                                    html: `Bạn đã sửa loại tin <b>${that.formData.name}</b> thành công!`,
                                    icon: 'success'
                                });
                                that.$emit('updateList', res.data.items);
                            }
                        });
                        break;
                    default:
                        swal({
                            title: "Bạn chắc chắn chứ?",
                            html: `Bạn sẽ xoá loại tin <i>${that.formData.name}</i>`,
                            icon: "warning",
                            buttons: true,
                            dangerMode: true,
                        })
                            .then((willDelete) => {
                                if (willDelete) {
                                    swal({
                                        title: 'Thành công!',
                                        html: `Bạn đã xóa loại sản phẩm thành công!`,
                                        icon: 'success'
                                    });
                                    that.$emit('updateList', res.data.items);
                                }
                            });

                        break;
                }

            }
        }
    }
</script>
