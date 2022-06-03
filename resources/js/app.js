/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

// window.Vue = require('vue');
window.bootbox = require('bootbox');
window.CustomDialog = require('./customDialog');
window.toastr = require('toastr');
window.Chart = require('chart.js');
const { v4: uuidv4 } = require('uuid');

window.Calendar = require('tui-calendar');

window.moment = require('moment');
window.uuidv4 = uuidv4;
window.tippy = require('tippy.js').default;
window.html2canvas = require('html2canvas');

import 'jquery-mask-plugin';
import 'jquery-ui/ui/widgets/datepicker.js';
import 'jquery-ui/ui/widgets/autocomplete.js';
import 'jquery-datetimepicker';
import 'gasparesganga-jquery-loading-overlay';


import "tui-calendar/dist/tui-calendar.css";
// If you use the default popups, use this.
import 'tui-date-picker/dist/tui-date-picker.css';
import 'tui-time-picker/dist/tui-time-picker.css';



window.toastr.options = {
  "closeButton": false,
  "debug": false,
  "newestOnTop": false,
  "progressBar": false,
  "positionClass": "toast-bottom-right",
  "preventDuplicates": false,
  "onclick": null,
  "showDuration": "300",
  "hideDuration": "1000",
  "timeOut": "3000",
  "extendedTimeOut": "1000",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut",
  "toastClass": 'alert',
}

$.LoadingOverlaySetup({
    background      : "rgba(0, 0, 0, 0.3)",
    image           : "../../../images/loaderatt.png",
    imageAnimation  : "1s fadein",
    imageAutoResize : true,
    imageResizeFactor: 1,
    maxSize                 : 50   ,
});

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
// Vue.component('students-component', require('./components/StudentsComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
// const app = new Vue({
//     el: '#app'
// });
