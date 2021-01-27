<template>
 <div class="col-lg-12">
    <h4 class="m-t-0 header-title"><b>Danh sách tài khoản</b></h4>
    <div class="row m-t-20">
        <div class="col-md-8">
            <button type="button" class="btn btn-success btn-sm" @click="showModal('create', defaultUser)"><i class="fa fa-plus"></i> Thêm</button>
        </div>
        <div class="col-md-4">
            <input type="text" placeholder="Tìm kiếm..." class="form-control input-sm" v-on:change="search($event.target.value)">
        </div>
    </div>

    <div class="m-t-20">
        <div class="table-responsive">
            <table class="table table-bordered m-0 ">
                    <thead>
                    <tr>
                        <th class="order text-center">#</th>
                        <th>Tên</th>
                        <th>Email</th>
                        <th>Di động</th>
                        <th>Giới tính</th>
                        <th>Trạng thái</th>
                        <th>Quyền</th>
                        <th class="created_at">Đăng nhập cuối</th>
                        <th class="created_at">Tạo lúc</th>
                        <th class="action-4"></th>
                    </tr>
                </thead>
                <tbody>
                    <template v-if="pages > 0">
                       <tr v-for="(customer, index) in customers" :key="index">
                            <td v-html="index + 1"></td>
                            <td v-html="customer.fullname"></td>
                            <td v-html="customer.email||customer.social_email"></td>
                            <td v-html="customer.mobile"></td>
                            <td v-html="vnGender(customer.gender)"></td>
                            <td v-html="getCustomerStatus(customer.status)"></td>
                            <td v-html="getRole(customer.role_id)" ></td>
                            <td v-html="customer.last_login"></td>
                            <td v-html="customer.created_at"></td>
                            <td class="text-center">
                                <button type="button" class="btn btn-success btn-sm" @click="showModal('view', customer)"><i class="fa fa-eye"></i></button>
                                <button type="button" class="btn btn-primary btn-sm" @click="showModal('edit', customer)"><i class="fa fa-edit"></i></button>
                                <button type="button" class="btn btn-danger btn-sm" @click="deleteItem(customer)"><i class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                    </template>
                    <template v-else>
                        <tr><td class="text-center" colspan="11">Không có dữ liệu</td></tr>
                    </template>

                </tbody>
            </table>
            <paginate
                v-if="pages > 1"
                :page-count="pages"
                :click-handler="clickCallBack"
                :prev-text="'Sau'"
                :next-text="'Trước'"
                :container-class="'pagination'">
            </paginate>
            <Modal :passAction="action" :passCustomer="passCustomer" @updateList="updateList"/>
        </div>
    </div>
</div>
</template>
<script>
import Modal from './ModalComponent';
export default {
    components: {
        Modal
    },
    data() {
        return {
            customers: {},
            pages: 0,
            currentPage: 1,
            action: 'create',
            passCustomer: {},
            defaultUser:{ gender:'female',status:1,role_id:1}
        }
    },
    created() {
        this.fetchData();
    },
    methods: {
        fetchData: function(page = 1) {
            const that = this;
            that.currentPage = page;
            axios.get('/admin/api/user?page=' + page).then(function(res) {
                that.customers = res.data.items;
                that.pages = res.data.pages;
            });
        },
        clickCallBack: function(page) {
            this.fetchData(page);
        },
        deleteItem: function(customer) {
            const that = this;
            swal({
                title: "Bạn chắc chắn chứ?",
                text: "tài khoản " + customer.fullname + " sẽ bị xóa khi bạn chấp nhận!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    axios.delete(`/admin/api/user/${customer.id}`).then(function(res) {
                        $('#lessonModal').modal('hide');
                        if(res.code === 200) {
                            swal({
                                title: 'Thành công!',
                                html: `Bạn đã xoá tài khoản <b>${customer.fullname}</b> thành công!`,
                                icon: 'success'
                            });
                            that.customers = res.data.items;
                        }
                    });
                }
            });
        },

        showModal(action, customer) {
            this.action = action;
            this.passCustomer = customer;
            $('#lessonModal').modal();
        },
        updateList(payload) {
            this.customers = payload;
        },
        search(value) {
            const that = this;
            axios.get(`/admin/api/user?search=${value}`).then(function(res) {
                that.customers = res.data.items;
                that.pages = res.data.pages;
            })
        },
        vnGender(value){

            let gender = 'Khác';

            if (value === 'male'){
                gender = 'Nam';
            }
            if(value === 'female'){
                gender = 'Nữ';
            }
            return gender;
        },
        getCustomerStatus(value){
            switch (value) {
                case 1:
                    value = '<i class="fa fa-circle text-success mr-2"></i> Đã kích hoạt';
                    break;
                default: value = '<i class="fa fa-circle text-danger mr-2"></i> Đang khóa';
            }
            return value;
        },
        getRole(value){
            switch (value) {
                case 1:
                    value = 'Admin';
                    break;
                default: value = 'Supper Admin';
            }
            return value;
        },
    }
}
</script>
