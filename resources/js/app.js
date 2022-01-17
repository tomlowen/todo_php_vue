require('./bootstrap');

import Vue from 'vue';
import { ValidationProvider, ValidationObserver, extend } from 'vee-validate';
import { required } from 'vee-validate/dist/rules';

extend("required", required);

Vue.component('TodoList', require('./components/TodoList.vue').default);
Vue.component('TodoApp', require('./components/TodoApp.vue').default);
Vue.component('ValidationProvider', ValidationProvider);
Vue.component('ValidationObserver', ValidationObserver);

new Vue({
    el:'#app',});
