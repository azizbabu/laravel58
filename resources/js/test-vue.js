window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
import App from './App.vue'
import VueRouter from 'vue-router'
import axios from 'axios'
import VueCkeditor from 'vue-ckeditor2';
// import VueSelect from 'vue-select'
import Toasted from 'vue-toasted';
import Datepicker from 'vuejs-datepicker';
import {store} from './store/store'
import {routes} from './routes'
// Vue.component('v-select', VueSelect.VueSelect);
Vue.use(axios)
Vue.use(VueCkeditor);
Vue.use(Toasted);
Vue.use(VueRouter)


const router = new VueRouter({
	// mode:'history',
	routes, // short for `routes: routes`
})

const app = new Vue({
    el: '#app',
    router,
    store,
    render: h => h(App)
});
