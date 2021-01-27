<template>
     <div class="x_panel">
        <div class="x_title">
            <h3>Danh sách khách hàng</h3>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Họ tên</th>
                        <th>Email</th>
                        <th>Điện thoại</th>
                        <th>Giới tính</th>
                        <th>Trạng thái</th>
                        <th>Ngày tạo</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                   <tr v-for="(user, index) in users" :key="index">
                       <td v-html="index + 1"></td>
                       <td v-html="user.fullname"></td>
                       <td v-html="user.email"></td>
                       <td v-html="user.mobile"></td>
                       <td v-html="user.gender"></td>
                       <td v-html="user.status"></td>
                       <td v-html="user.created_at"></td>
                       <td>
                           <button class="btn btn-danger"><i class="fa fa-trash"></i></button>
                           <button class="btn btn-primary"><i class="fa fa-pencil"></i></button>
                       </td>
                   </tr>
                </tbody>
            </table>
            <div class="ln_solid"></div>
            <paginate
                v-if="pages > 1"
                :page-count="pages"
                :click-handler="clickCallBack"
                :prev-text="'Sau'"
                :next-text="'Trước'"
                :container-class="'pagination'">
            </paginate>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            users: {},
            pages: 0
        }
    },
    created() {
        this.fetchData();
    },
    methods: {
        fetchData: function(page = 1) {
            const that = this;
            axios.get('/admin/api/customer?page=' + page).then(function(res) {
                that.users = res.data.items;
                that.pages = res.data.pages;
            });
        },
        clickCallBack: function(page) {
            this.fetchData(page);
        }
    }
}
</script>
<style>

</style>
