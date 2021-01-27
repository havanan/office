
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
window.swal = require('sweetalert');
window.toastr = require('toastr');
window.moment = require('moment-timezone');
moment.locale('vi');
moment.tz.setDefault(process.env.MIX_TIME_ZONE)
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

 import {myMixin} from './mixin';
 Vue.mixin(myMixin);

import vSelect from "vue-select";

window.Vue.component('customer-component', require('./components/customer/IndexComponent.vue').default);
window.Vue.component('comment-component', require('./components/comments/IndexComponent.vue').default);
window.Vue.component('config-component', require('./components/configs/IndexComponent.vue').default);
window.Vue.component('category-component', require('./components/category/IndexComponent.vue').default);
window.Vue.component('tag-component', require('./components/tag/IndexComponent.vue').default);
window.Vue.component('news-component', require('./components/news/IndexComponent.vue').default);
window.Vue.component('news-form-component', require('./components/news/FormComponent.vue').default);
window.Vue.component('feedback-component', require('./components/feedback/IndexComponent.vue').default);
window.Vue.component('user-component', require('./components/users/IndexComponent.vue').default);
window.Vue.component('v-select', vSelect);

const app = new Vue({
    el: '#wrapper'
});
