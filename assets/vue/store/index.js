import Vue from "vue";
import Vuex from "vuex";
import RateModule from "./rate";
import ActualRateModule from "./actual";

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        rate: RateModule,
        actual: ActualRateModule,
    }
});