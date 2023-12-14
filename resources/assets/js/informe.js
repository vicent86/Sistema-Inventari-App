require('./vue-asset');
Vue.component('report-form', require('./components/informe/ReportForm.vue').default);

const app = new Vue({
    el: '#app'
});
