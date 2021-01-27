<template>
  <div class="modal fade" id="lessonModal" tabindex="-1" role="dialog" aria-hidden="true">   
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Thông tin bài học</h4>
        </div>
         <form class="form-horizontal form-label-left" @submit.prevent="onSubmit">
            <div class="modal-body">
                <div class="col-md-12 center-margin">
                    <div class="form-group">
                        <label>Khoá học </label>
                        <select class="form-control" v-model="formData.course_id" required>
                            <option  v-for="(course, index) in courses" :value="course.id" :key="index" v-html="course.name"></option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tên bài học </label>
                        <textarea class="form-control" v-model="formData.title" required :disabled="action == 'view'"></textarea>
                        <div class="error" v-html="getValidation('title')"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Huỷ</button>
                <button type="submit" class="btn btn-primary" v-if="action == 'edit' || action == 'create'">Xử lý</button>
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
            lesson: this.passLesson,
            formData: {
                title: '',
                course_id: ''
            },
            courses: this.passCourses
        }
    },
    props: ['passAction', 'passLesson', 'passCourses'],
    watch: {
        passAction: function(value) {
            this.action = value
            this.setValidation({});
        },
        passLesson: function(value) {
            this.formData.title = value.title;
            this.formData.course_id = value.course_id ?? 6;
            this.lesson = value;
            this.setValidation({});
        },
        passCourses(value) {
            this.courses = value
        }
    },
    methods: {
        onSubmit: function() {
            const that = this;
            switch(that.action) {
                case 'create':
                    axios.post('/admin/api/lesson', that.formData).then(function(res) {
                        $('#lessonModal').modal('hide');
                        if(res.code == 200) {
                            swal({
                                title: 'Thành công!',
                                html: `Bạn đã tạo bài học <b>${that.formData.title}</b> thành công!`,
                                icon: 'success'
                            });
                            that.$emit('updateList', res.data.items);
                        }
                    }).catch(err => {
                        that.setValidation(err)
                    });
                    break;
                case 'edit':
                    axios.put(`/admin/api/lesson/${that.lesson.id}`, that.formData).then(function(res) {
                        $('#lessonModal').modal('hide');
                        if(res.code == 200) {
                            swal({
                                title: 'Thành công!',
                                html: `Bạn đã sửa bài học <b>${that.formData.title}</b> thành công!`,
                                icon: 'success'
                            });
                            that.$emit('updateList', res.data.items);
                        }
                    }).catch(err => {
                        that.setValidation(err)
                    });
                    break;
                default:
                    swal({
                        title: "Bạn chắc chắn chứ?",
                        html: `Bạn sẽ xoá bài học <i>${that.formData.title}</i>`,
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