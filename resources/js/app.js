/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import { createApp } from 'vue';
import FormBuilder from './components/FormBuilder.vue';

document.addEventListener('DOMContentLoaded', () => {
    const app = createApp({});
    app.component('form-builder', FormBuilder);
    app.mount('#app');
});
