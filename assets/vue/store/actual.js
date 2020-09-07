import RateAPI from "../api/rate";

const
    FETCHING_RATES = "FETCHING_RATES",
    FETCHING_RATES_SUCCESS = "FETCHING_RATES_SUCCESS",
    FETCHING_RATES_ERROR = "FETCHING_RATES_ERROR"
;

export default {
    namespaced: true,
    state: {
        isLoading: false,
        error: null,
        rates: [],
        currencies: [],
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
        },
        currencies(state) {
            return state.currencies;
        },
    },
    mutations: {
        [FETCHING_RATES](state) {
            state.isLoading = true;
            state.error = null;
            state.rates = [];
            state.currencies = [];
        },
        [FETCHING_RATES_SUCCESS](state, data) {
            state.isLoading = false;
            state.error = null;
            state.rates = data.rates;
            state.currencies = data.currencies;
        },
        [FETCHING_RATES_ERROR](state, error) {
            state.isLoading = false;
            state.error = error;
            state.rates = [];
            state.currencies = [];
        },
    },
    actions: {
        async findActual({ commit }) {
            commit(FETCHING_RATES);
            try {
                let response = await RateAPI.findLatest();
                let rates = {};
                let currencies = {};
                for (let rate of response.data) {
                    currencies[rate.baseCurrency] = rate.baseCurrency;
                    currencies[rate.quoteCurrency] = rate.quoteCurrency;
                    let k = rate.baseCurrency + rate.quoteCurrency;
                    rates[k] = rate;
                }
                currencies = Object.values(currencies);

                commit(FETCHING_RATES_SUCCESS, {
                    currencies,
                    rates,
                });
                return rates;
            } catch (error) {
                commit(FETCHING_RATES_ERROR, error);
                return null;
            }
        }
    }
};