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
          <select v-model="baseCurrency" class="form-control">
            <option v-for="option in currenciesList" v-bind:value="option">
              {{ option }}
            </option>
          </select>
        </div>
        <div class="form-group col-3">
          <select v-model="quoteCurrency" class="form-control">
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
      amount: "0.0",
      baseCurrency: '',
      quoteCurrency: '',
    };
  },
  computed: {
    calculated() {
      return this.amount * 2;
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
  created() {
    this.$store.dispatch("actual/findActual");
  },
};
</script>