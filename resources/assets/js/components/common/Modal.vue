<template>
  <div class="modal fade" :id="id" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">   
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" @click="$emit('closeModal', false)"><span aria-hidden="true">&times;</span></button>
                <slot name="header">
                    <h4 class="modal-title">Thông tin</h4>
                </slot>
            </div>
            <div class="modal-body">
                <slot name="body">
                    Hello
                </slot>
            </div>
            <div class="modal-footer">
                <slot name="footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" @click="$emit('closeModal', false)">Huỷ</button>
                    <button type="button" class="btn btn-primary" @click="$emit('processModal')">Xử lý</button>
                </slot>
            </div>
        </div>
    </div>
 </div>
</template>
<script>
export default {
    data() {
        return {
            idName: this.id,
            isShowModal: this.showModal
        }
    },
    props: ['id', 'showModal'],
    watch: {
        showModal(value) {
            this.isShowModal = value
        },
        isShowModal(value) {
            const isShow = value ? 'show' : 'hide'
            $(`#${this.idName}`).modal(isShow);
        }
    }


}
</script>