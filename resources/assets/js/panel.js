require('./vue-asset');
Vue.component('info-box', require('./components/panel/Info-Box.vue').default);
new Vue({
    el: '#app'
});
