import '../scss/app.scss';
import 'bootstrap';

import Vue from 'vue';
import App from './main';

new Vue({
    render: (h) => h(App),
}).$mount('#app');
