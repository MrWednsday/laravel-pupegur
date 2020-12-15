/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Import JavaScript Dependencies
 */

import moment from 'moment';

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('comments', require('./components/Comments.vue').default);
Vue.component('comment', require('./components/Comment.vue').default);
Vue.component('textarea-auto-size', require('./components/TextareaAutoSize.vue').default);
Vue.component('image-upload', require('./components/ImageUpload.vue').default);
Vue.component('image-preview', require('./components/ImagePreview.vue').default);
Vue.component('post-delete-button', require('./components/DeletePost.vue').default);
Vue.component('user-data', require('./components/UserData.vue').default);
Vue.component('add-tags', require('./components/AddTags.vue').default);
Vue.component('post-title', require('./components/PostTitle.vue').default);
Vue.component('profile-image-update', require('./components/ProfileImageUpdate.vue').default);





/**
 * Create global functions
 */

Vue.filter('formatDate', function(value) {
    if (value) {
        return moment(String(value)).format('YYYY-MM-DD hh:mm:ss')
    }
});

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});