import Vue from "vue";
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import ConvertorApp from "./ConvertorApp";
import router from "./router";
import store from "./store";
import moment from 'moment';

// Install BootstrapVue
Vue.use(BootstrapVue)

new Vue({
    components: { ConvertorApp },
    template: "<ConvertorApp/>",
    router,
    store
}).$mount("#convertor");

Vue.filter('formatDate', function(value) {
    if (value) {
        return moment(String(value)).format('DD/MM/YYYY')
    }
});