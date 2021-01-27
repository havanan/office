<template>
 <div class="col-lg-12">
    <h4 class="m-t-0 header-title"><b>Danh sách comment</b></h4>
    <div class="row m-t-20">
        <div class="col-md-3 m-b-5" >
            <div class="col-md-12" style="background-color: #3B3A38; padding: 8px">
                <div class="form-inline">
                    <div class="form-group stick-co">
                        <i class="md  md-brightness-1 md-48"></i>
                        <span>Ghim</span>
                    </div>
                    <div class="form-group unread-co">
                        <i class="md  md-brightness-1 "></i>
                        <span>Chưa đọc</span>
                    </div>
                    <div class="form-group read-co">
                        <i class="md  md-brightness-1 md-48 "></i>
                        <span>Đã đọc</span>
                    </div>
                    <div class="form-group success-co">
                        <i class="md  md-brightness-1 md-48 "></i>
                        <span>Đã trả lời</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="row">
                <div class="col-md-2 m-b-5">
                     <select class="form-control" v-model="mdlCourse">
                        <option value="0">Tất cả khoá học</option>
                        <option  v-for="(course, index) in passCourses" :value="course.id" :key="index" v-html="course.name"></option>
                    </select>
                </div>
                <div class="col-md-3 m-b-5">
                     <select2 :options="sltLessons" v-model="mdlLesson">
                        <option value="0">Tất cả bài học</option>
                    </select2>
                </div>
                <div class="col-md-2 m-b-5">
                     <select class="form-control" v-model="mdlLessonCategory">
                        <option value="0">Tất cả loại bài học</option>
                        <option  v-for="(category, index) in sltCategories" :value="category.lesson_category_id" :key="index" v-html="category.category_name"></option>
                    </select>
                </div>
                <div class="col-md-2 m-b-5">
                     <select class="form-control" v-model="mdlStatus">
                        <option value="0">Tất cả loại bình luận</option>
                        <option  v-for="(item, index) in status" :value="item.id" :key="index" v-html="item.text"></option>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="text" placeholder="Tìm kiếm..." class="form-control" v-model="strSearch" @keypress.enter="search">
                </div>
            </div>
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="m-t-20">
        <div class="table-responsive">
            <table class="table m-0 table-reponsive">
                    <thead>
                    <tr>
                        <th class="order text-center">#</th>
                        <th class="text-right"></th>
                        <th class="w-150p"></th>
                        <th class="action-2"></th>
                    </tr>
                </thead>
                <tbody>
                    <template v-if="pages > 0">
                        <template v-for="(comment, index) in comments">
<!--                            :class="getStatusColor(comment.status)"-->
                            <tr class="pointer" :class="getStatusColor(comment.status)">
                                <td style="background-color: white;"><strong v-html="comment.id"></strong></td>
                                <td>
                                    <div class="row">
                                        <div class="col-md-1 text-center">
                                            <template v-if="comment.customer_avatar">
                                                <img :src="avtUrl+comment.customer_avatar" class="avt" />
                                            </template>
                                            <template v-else>
                                                <div class="avt no-avt">
                                                    <span v-html="getFirstOfName(comment.customer_name)"></span>
                                                </div>
                                            </template>
                                        </div>
                                        <div class="col-md-10">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <p class="success-co"><strong v-html="comment.customer_name"></strong></p>
                                                </div>
                                                <div class="col-md-10">
                                                    <i class="fa fa-bookmark success-co"></i>
                                                    <strong><span v-html="comment.course_name"></span></strong>
                                                    <i v-if="comment.lesson_contents_title" class="fa fa-chevron-right"></i>
                                                    <a :href="goToLesson(comment)" target="_blank">{{comment.lesson_contents_title}}</a>
                                                </div>
                                            </div>
                                            <p><span v-html="comment.created_at"></span></p>
                                            <p v-html="comment.content"></p>
                                            <p class="icon-cmt" @click="showCmt(index)"><i class="fa fa-comment success-co m-r-5"></i> {{comment.children.length}}</p>
                                            <div :id="'child'+index" class="hide">
                                                <div class="row child" v-if="comment.children"  v-for="(children, key) in comment.children">
                                                    <div class="col-md-2 text-center">
                                                        <template v-if="children.customer.avatar">
                                                            <img :src="avtUrl+children.customer.avatar" class="avt" />
                                                        </template>
                                                        <template v-else>
                                                            <div class="avt no-avt">
                                                                <span v-html="children.customer && children.customer.fullname ? getFirstOfName(children.customer.fullname) : 'NO'"></span>
                                                            </div>
                                                        </template>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <p class="success-co"><strong>{{children.customer.fullname}}</strong></p>
                                                        <p v-html="children.created_at"></p>
                                                        <p v-html="children.content"></p>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <button type="button" class="btn btn-danger btn-sm" @click="deleteItem(children)"><i class="fa fa-trash"></i></button>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2 text-right"></div>
                                                    <div class="col-md-10">
                                                        <div class="form-group text-right">
                                                            <textarea class="form-control" placeholder="Nội dung trả lời khách hàng" v-model="formCmt[index].content"></textarea>
                                                            <button class="btn btn-primary mt-10"  @click="reply(comment,index)">Trả lời</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <select class="form-control" @change="changeStatus($event.target, comment.id)" v-model="comment.status">
                                        <option v-for="st in status" :value="st.id">{{st.text}}</option>
                                    </select>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm" @click="deleteItem(comment)"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                        </template>
                    </template>
                    <template v-else>
                        <tr><td colspan="8" class="text-center">Không có dữ liệu</td></tr>
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
import Select2 from '../common/Select2';
export default {
    components: {
        Modal,
        Select2
    },
    data() {
        return {
            comments: {},
            comment: {},
            pages: 0,
            currentPage: 1,
            action: 'create',
            passCourses: {},
            courseId: '',
            strSearch: '',
            mdlLesson: 0,
            mdlLessonCategory: 0,
            mdlCourse: 0,
            mdlStatus: 0,
            sltLessons: [],
            sltCategories: [],
            isLoading: true,
            showModal: false,
            frontendUrl: 'https://rakurakuvietnam.com/course/',
            avtUrl:'https://admin.rakurakuvietnam.com/storage/avatar/',
            status: [
                {id: 1, text: 'Ghim'},
                {id: 2, text: 'Chưa đọc'},
                {id: 3, text: 'Đã đọc'},
                {id: 4, text: 'Đã trả lời'}
            ],
            formData: {
                content: '',
                lesson_content_id: this.c,
                status: '3'
            },
            formCmt:[],
        }
    },
    watch: {
        mdlCourse(value) {
            this.currentPage = 1
            this.search();
            this.loadDataDropdown(1);
        },
        mdlLesson(value) {
            this.currentPage = 1
            this.search();
            this.loadDataDropdown(2);
        },
        mdlLessonCategory(value) {
            this.currentPage = 1
            this.search();
        },
        mdlStatus(value) {
            this.currentPage = 1
            this.search();
        },
    },
    created() {
        this.fetchData();
    },
    methods: {
        fetchData: function(page = 1) {
            const that = this;
            that.currentPage = page;
            axios.get('/admin/api/comment?page=' + page).then(function(res) {
                that.makeListFormCmt(res.data.items);
                that.comments = res.data.items;
                that.pages = res.data.pages;
                that.currentPage = res.data.currentPage;

            });
            axios.get('/admin/api/course').then(function(res) {
                that.passCourses = res.data;
            });
            this.loadDataDropdown(1);
        },
        makeListFormCmt(comments){
           const length = comments.length;
           const that = this;
          if (comments && length > 0) {
              for (let i = 0; i < length; i++) {
                  const cmt = {
                      content :''
                  }
                  that.formCmt[i] = cmt;
              }
          }
        },
        clickCallBack: function(page) {
            this.currentPage = page;
            this.search()
        },
        deleteItem: function(comment) {
            const that = this;
            swal({
                title: "Bạn chắc chắn chứ?",
                text: "Bình luận " + comment.comment_content + " sẽ bị xóa khi bạn chấp nhận!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    axios.delete(`/admin/api/comment/${comment.id}`).then(function(res) {
                        if(res.code == 200) {
                            swal({
                                title: 'Thành công!',
                                html: `Bạn đã xoá bình luận <b>${comment.content}</b> thành công!`,
                                icon: 'success'
                            });
                            that.search();
                        }
                    });
                }
            });
        },
        updateList(payload) {
            this.lessons = payload;
        },
        search() {
            const that = this;
            that.isLoading = true
            const url = `/admin/api/comment?page=${that.currentPage}&search=${that.strSearch}&course=${that.mdlCourse}&lesson=${that.mdlLesson}&category=${that.mdlLessonCategory}&status=${that.mdlStatus}`;
            axios.get(url).then(function(res) {
                that.comments = res.data.items;
                that.pages = res.data.pages;
                that.isLoading = false
            })
        },
        loadDataDropdown($type) {
            const that = this;
            switch($type) {
                case 1:
                    axios.get(`/admin/api/lesson?page=-1&courseId=${that.mdlCourse}`).then(res => {
                        that.sltLessons = res.data.items
                        const first = {id:0, vn_title: 'Tất cả bài học',jp_title:''}
                        that.sltLessons.unshift(first)
                        that.sltLessons.map(x => {
                            return x.text = x.vn_title+x.jp_title;
                        });
                    });
                    break;
                case 2:
                    axios.get(`/admin/api/lesson/content/get/category/${that.mdlLesson}`).then(res => {
                        that.sltCategories = res.data
                    });
                    break;
                default:
                    break;
            }
        },
        getStatusColor(status) {
            switch (status) {
                case '4':
                    return 'success'
                    break;
                case '3':
                    return 'active'
                    break;
                case '1':
                    return 'warning'
                    break;
                default:
                    return 'danger'
                    break;
            }
        },
        displayModal(value) {
            this.comment = value;
            this.formData.lesson_content_id = value.lesson_content_id;
            this.formData.status = value.status
            this.formData.content = ''
            this.showModal = true;
        },
        reply(comment,index) {
            const that = this;
            if (!that.formCmt[index]||!that.formCmt[index].content){
                return false;
            }
            const formPost = {
                content: that.formCmt[index].content,
                lesson_content_id: comment.lesson_content_id,
                status: '3'
            }
            axios.post(`/admin/api/comment/${comment.id}`, formPost).then(res => {
                that.showModal = false;
                swal({
                        title: 'Thành công!',
                        html: `Bạn đã trả lời bình luận <code>${comment.content}</code> thành công!`,
                        icon: 'success'
                    });
                that.formCmt[index].content = '';
                that.fetchData(that.currentPage);
            });
        },
        addComment() {
            const that = this;
            axios.get('/admin/comment/socket/1').then(res => {
            });
        },
        getRealtimeData() {
            const that = this;
            socket.on('comment', res => {
                const data = JSON.parse(res);
                that.comments = data.items;
                that.pages = data.pages;
                that.currentPage = 1
            });

             socket.emit('join', 'comment');

        },
        changeStatus(element, id) {
            const that = this;
            axios.get('/admin/api/comment/' + id + '/' + element.value ).then(res => {
                swal({
                    title: 'Thành công!',
                    html: `Bạn đã đổi trạng thái bình luận <code>${that.comment.comment_content}</code> thành công!`,
                    icon: 'success'
                });
                this.fetchData(that.currentPage);
            });
        },
        goToLesson(comment){
            let url = '';
            if (comment){
                url = this.frontendUrl+comment.course_slug+'/'+comment.milestone_id+'/'+comment.lesson_id+'/'
                if (comment.course_slug === '発音') {
                    url += comment.lesson_contents_slug
                }else {
                    url += comment.lesson_contents_slug
                }
            }
           return url;
        },
        getFirstOfName(name){
            let result = '';
            if (name){
                result = name.charAt(0)
            }

            return result;
        },
        showCmt(index){
            const id = '#child'+index;
            $(id).toggleClass('show');
        }
    },
    mounted() {
        this.getRealtimeData();
    }
}
</script>
