require('./bootstrap');

import Vue from 'vue';
Vue.component('TodoList', require('./components/TodoList.vue').default);

new Vue({
    el:'#app',
});
