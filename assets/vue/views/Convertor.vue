<template>
  <div>
    <div class="row col">
      <h1>Convertor</h1>
    </div>

    <div class="row col">
      <div class="form-row">
        <div class="form-group col-3">
          <input type="number" v-model="amount" class="form-control">
        </div>
        <div class="form-group col-3">
          <select v-model="baseCurrency" @change="onCurrencyChange($event)" class="form-control">
            <option v-for="option in currenciesList" v-bind:value="option">
              {{ option }}
            </option>
          </select>
        </div>
        <div class="form-group col-3">
          <select v-model="quoteCurrency" @change="onCurrencyChange($event)" class="form-control">
            <option v-for="option in currenciesList" v-bind:value="option">
              {{ option }}
            </option>
          </select>
        </div>
        <div class="form-group col-3">
          <input v-model="calculated" type="number" readonly class="form-control-plaintext">
        </div>
      </div>
    </div>

    <div v-if="isLoading" class="row col">
      <p>Loading...</p>
    </div>

    <div v-else-if="hasError" class="row col">
      <div class="alert alert-danger" role="alert">
        {{ error }}
      </div>
    </div>

    <div v-else-if="!hasRates" class="row col">
      No rates!
    </div>

  </div>
</template>

<script>
export default {
  name: "Convertor",
  data() {
    return {
      amount: 0,
      rate: 0,
      baseCurrency: '',
      quoteCurrency: '',
    };
  },
  computed: {
    calculated() {
      return this.amount * this.rate;
    },
    isLoading() {
      return this.$store.getters["actual/isLoading"];
    },
    hasError() {
      return this.$store.getters["actual/hasError"];
    },
    error() {
      return this.$store.getters["actual/error"];
    },
    hasRates() {
      return this.$store.getters["actual/hasRates"];
    },
    rates() {
      return this.$store.getters["actual/rates"];
    },
    currenciesList() {
      return this.$store.getters["actual/currencies"];
    },
  },
  methods: {
    onCurrencyChange(event) {
      let rateValue = this.getRate(this.baseCurrency, this.quoteCurrency);
      if (rateValue) {
        this.rate = rateValue;
      } else {
        this.rate = 0;
        this.error = 'Sorry, it is not possible to calculate the amount'
      }
    },
    getRate() {
      // try to get rate from existing ones or from reversed
      let rateValue = this.getExplicitRate(this.baseCurrency, this.quoteCurrency);
      if (rateValue) {
        return rateValue;
      }

      // try to calculate with intermediate currency
      // e.g. we have USDJPY JPYEUR -> get USDEUR as USDJPY*JPYEUR
      for (const rate of Object.values(this.rates)) {
        if (rate.baseCurrency === this.baseCurrency) {
          let computed = this.getExplicitRate(rate.quoteCurrency, this.quoteCurrency);
          if (computed) {
            return computed * rate.rate;
          }
        }

        // try to calculate with intermediate reverse currency
        // e.g. we have JPYUSD EURJPY -> get USDEUR as EURJPY/JPYUSD
        if (rate.quoteCurrency === this.baseCurrency) {
          let computed = this.getExplicitRate(rate.baseCurrency, this.quoteCurrency);
          if (computed) {
            return computed / rate.rate;
          }
        }
      }

      return 0;
    },
    getExplicitRate(baseCurrency, quoteCurrency) {
      if (baseCurrency === quoteCurrency) {
        return 1;
      }

      let direct = baseCurrency + quoteCurrency;
      if (direct in this.rates) {
        return this.rates[direct].rate;
      }

      let reverse = quoteCurrency + baseCurrency;
      if (reverse in this.rates) {
        return 1 / this.rates[reverse].rate;
      }
    },
  },
  created() {
    this.$store.dispatch("actual/findActual");
  },
};
</script>