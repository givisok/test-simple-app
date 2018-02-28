/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import store from './store/index.js'
import VeeValidate from 'vee-validate';

Vue.use(VeeValidate);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.component('shop-cart', require('./components/ShopCart.vue'));
Vue.component('product', require('./components/Product.vue'));
Vue.component('checkout', require('./components/Checkout.vue'));

/**
 * We need to yse vue route + vuex.
 * But I try to speed up simple up development
 */

const app = new Vue({
    el: '#app',
    data: {
        myValue: 1
    },
    store: store,
    computed: {
        cartCount() {
            return this.$store.getters.count;
        }
    }
});
