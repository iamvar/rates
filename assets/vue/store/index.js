import Vue from "vue";
import Vuex from "vuex";
import RateModule from "./rate";

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        rate: RateModule
    }
});