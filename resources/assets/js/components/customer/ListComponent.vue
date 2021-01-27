<template>
 <div class="col-lg-12">
    <h4 class="m-t-0 header-title"><b>Danh sách khách hàng</b></h4>
    <div class="row m-t-20">
        <div class="col-md-8">
            <button type="button" class="btn btn-success btn-sm" @click="showModal('create', { gender:'female',status:0})"><i class="fa fa-plus"></i> Thêm</button>
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
                        <th class="order text-center">Id</th>
                        <th>Khách hàng</th>
                        <th>Giới tính</th>
                        <th>Trạng thái</th>
                        <th class="text-center">Tài khoản test</th>
<!--                        <th class="text-center">Xác thực</th>-->
<!--                        <th class="created_at">Đăng nhập cuối</th>-->
                        <th class="created_at">Tạo lúc</th>
                        <th class="action-4"></th>
                    </tr>
                </thead>
                <tbody>
                    <template v-if="pages > 0">
                       <tr v-for="(customer, index) in customers" :key="index">
                            <td v-html="customer.id"></td>
                            <td>
                               <h4 class="text-primary" ><strong v-html="customer.fullname"></strong></h4>
                                <p><i class="fa fa-envelope-o"></i> {{customer.email||customer.social_email}}</p>
                                <p v-if="customer.mobile"> <i class="fa fa-phone"></i> {{customer.mobile}}</p>
                            </td>
                            <td v-html="vnGender(customer.gender)"></td>
                            <td v-html="getCustomerStatus(customer.status)"></td>
                           <td v-html="getCustomerActive(customer.is_tester)" class="text-center pointer" @click="updateField('is_tester',customer)"></td>
<!--                           <td v-html="getCustomerActive(customer.is_verified)" class="text-center"></td>-->
<!--                            <td v-html="customer.last_login"></td>-->
                            <td v-html="customer.created_at"></td>
                            <td class="text-center">
                                <button type="button" class="btn btn-success btn-sm" @click="showModal('view', customer)"><i class="fa fa-eye"></i></button>
                                <button type="button" class="btn btn-primary btn-sm" @click="showModal('edit', customer)"><i class="fa fa-edit"></i></button>
                                <button type="button" class="btn btn-danger btn-sm" @click="deleteItem(customer)"><i class="fa fa-trash"></i></button>
                                <!-- <button class="btn btn-warning" title="Đăng nhập tài khoản người dùng" @click="customerLogin(customer.id)"><i class="fa fa-sign-in"></i></button> -->
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
            passCustomer: {}
        }
    },
    props: [
        'customerStatus'
    ],
    created() {
        this.fetchData();
    },
    methods: {
        fetchData: function(page = 1) {
            const that = this;
            that.currentPage = page;
            axios.get('/admin/api/customer?page=' + page).then(function(res) {
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
                text: "Khách hàng " + customer.fullname + " sẽ bị xóa khi bạn chấp nhận!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    axios.delete(`/admin/api/customer/${customer.id}`).then(function(res) {
                        $('#lessonModal').modal('hide');
                        if(res.code === 200) {
                            swal({
                                title: 'Thành công!',
                                html: `Bạn đã xoá khách hàng <b>${customer.fullname}</b> thành công!`,
                                icon: 'success'
                            });
                            that.fetchData(that.currentPage);
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
            axios.get(`/admin/api/customer?search=${value}`).then(function(res) {
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
        getCustomerActive(value){
            switch (value) {
                case 1:
                    value = '<i class="fa fa-check text-success mr-2"></i> ';
                    break;
                default: value = '<i class="fa fa-ban text-danger mr-2"></i> ';
            }
            return value;
        },
        customerLogin(customer_id){
            alert(customer_id);
        },
        updateField(field_name,customer){
            const that = this;
            const formData = {
                id:customer.id,
                field: field_name
            }
            axios.post(`/admin/api/customer/update-by-field`,formData).then(function(res) {
                swal({
                    title: 'Thành công!',
                    text: 'Bạn đã cập nhật khách hàng '+customer.fullname+' thành công!',
                    icon: 'success'
                });
                that.fetchData(that.currentPage);
            })
        }
    }
}
</script>
