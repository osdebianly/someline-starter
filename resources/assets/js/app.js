/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

// Vue Directives
Vue.directive('focus', require('./directives/focus'));

// Vue Filters
Vue.filter('nl2br', require('./filters/nl2br'));
Vue.filter('booleanFormat', require('./filters/booleanFormatter'));
Vue.filter('percentageFormat', require('./filters/percentageFormatter'));
Vue.filter('byteFormat', require('./filters/byteFormatter'));
Vue.filter('timestampFormat', require('./filters/timestampFormatter'));

// Vue Mixins
import MixInUser from './mixins/user'
import MixInJQuery from './mixins/jquery'
import MixInTools from './mixins/tools'
Vue.mixin(MixInUser);
Vue.mixin(MixInJQuery);
Vue.mixin(MixInTools);
// Vue Element
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-default/index.css';

Vue.use(ElementUI);

// Vue Components
Vue.component('autosize-textarea', require('./essentials/autosize-textarea.vue'));

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the body of the page. From here, you may begin adding components to
 * the application, or feel free to tweak this setup for your needs.
 */


Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue')
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue')
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue')
);

Vue.component('example', require('./components/Example.vue'));
Vue.component('sl-user-list', require('./components/user/UserList.vue'));
Vue.component('sl-oauth', require('./components/console/OAuth.vue'));

Vue.component('my-menu-list', require('./components/menu/MenuList.vue'));
Vue.component('role-list', require('./components/rbac/RoleList.vue'));
Vue.component('permission-list', require('./components/rbac/PermissionList.vue'));
Vue.component('admin-list', require('./components/rbac/AdminList.vue'));
Vue.component('menu-list', require('./components/rbac/MenuList.vue'));



const app = new Vue({
    el: '#app',
    data: {
        msg: "hello",
    },
    methods: {
        initLocale(){
            console.log('Init Locale.');

        },
    },
    watch: {},
    events: {},
    created(){
        console.log('Bootstrap.');
        this.initLocale();
    }
});
// const app = new Vue({
//     el: 'body',
//     data: {
//         msg: "hello",
//     },
//     methods: {
//         initLocale(){
//             console.log('Init Locale.');
//
//             var that = this;
//             var lang = this.locale;
//
//             Vue.config.lang = lang;
//             Vue.locale(lang, window.Someline.locales);
//
//         },
//     },
//     watch: {},
//     events: {},
//     created(){
//         console.log('Bootstrap.');
//         this.initLocale();
//     },
//     mounted(){
//         console.log('Ready.');
//     }
// });
