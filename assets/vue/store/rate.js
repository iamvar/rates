import RateAPI from "../api/rate";

const CREATING_RATE = "CREATING_RATE",
    CREATING_RATE_SUCCESS = "CREATING_RATE_SUCCESS",
    CREATING_RATE_ERROR = "CREATING_RATE_ERROR",
    FETCHING_RATES = "FETCHING_RATES",
    FETCHING_RATES_SUCCESS = "FETCHING_RATES_SUCCESS",
    FETCHING_RATES_ERROR = "FETCHING_RATES_ERROR",
    RETRIEVE_RATES = "RETRIEVE_RATES",
    RETRIEVE_RATES_SUCCESS = "RETRIEVE_RATES_SUCCESS",
    RETRIEVE_RATES_ERROR = "RETRIEVE_RATES_ERROR"
;

export default {
    namespaced: true,
    state: {
        isLoading: false,
        error: null,
        rates: []
    },
    getters: {
        isLoading(state) {
            return state.isLoading;
        },
        hasError(state) {
            return state.error !== null;
        },
        error(state) {
            return state.error;
        },
        hasRates(state) {
            return state.rates.length > 0;
        },
        rates(state) {
            return state.rates;
        }
    },
    mutations: {
        [CREATING_RATE](state) {
            state.isLoading = true;
            state.error = null;
        },
        [CREATING_RATE_SUCCESS](state, rate) {
            state.isLoading = false;
            state.error = null;
            state.rates.unshift(rate);
        },
        [CREATING_RATE_ERROR](state, error) {
            state.isLoading = false;
            state.error = error;
            state.rates = [];
        },
        [FETCHING_RATES](state) {
            state.isLoading = true;
            state.error = null;
            state.rates = [];
        },
        [FETCHING_RATES_SUCCESS](state, rates) {
            state.isLoading = false;
            state.error = null;
            state.rates = rates;
        },
        [FETCHING_RATES_ERROR](state, error) {
            state.isLoading = false;
            state.error = error;
            state.rates = [];
        },
        [RETRIEVE_RATES](state) {
            state.isLoading = true;
            state.error = null;
            state.rates = [];
        },
        [RETRIEVE_RATES_SUCCESS](state, rates) {
            state.isLoading = false;
            state.error = null;
            state.rates = rates;
        },
        [RETRIEVE_RATES_ERROR](state, error) {
            state.isLoading = false;
            state.error = error;
            state.rates = [];
        }
    },
    actions: {
        async create({ commit }, message) {
            commit(CREATING_RATE);
            try {
                let response = await RateAPI.create(message);
                commit(CREATING_RATE_SUCCESS, response.data);
                return response.data;
            } catch (error) {
                commit(CREATING_RATE_ERROR, error);
                return null;
            }
        },
        async findAll({ commit }) {
            commit(FETCHING_RATES);
            try {
                let response = await RateAPI.findAll();
                commit(FETCHING_RATES_SUCCESS, response.data);
                return response.data;
            } catch (error) {
                commit(FETCHING_RATES_ERROR, error);
                return null;
            }
        },
        async retrieve({ commit }) {
            commit(RETRIEVE_RATES);
            try {
                let response = await RateAPI.retrieve();
                commit(RETRIEVE_RATES_SUCCESS, response.data);
                return response.data;
            } catch (error) {
                commit(RETRIEVE_RATES_ERROR, error);
                return null;
            }
        }
    }
};