<template>
  <div>
    <div class="row col">
      <h1>Rates</h1>
    </div>

    <div class="row col">
      <form>
        <div class="form-row">
          <div class="col-12">
            <button
                :disabled="isLoading"
                type="button"
                class="btn btn-primary"
                @click="retrieveRates()"
            >
              Retrieve Rates from all sources
            </button>
          </div>
        </div>
        <div class="form-row">
          <div class="col-8">
            <input v-model="message" type="text" class="form-control">
          </div>
          <div class="col-4">
            <button
                :disabled="message.length === 0 || isLoading"
                type="button"
                class="btn btn-primary"
                @click="createRate()"
            >
              Create
            </button>
          </div>
        </div>
      </form>
    </div>

    <div v-if="isLoading" class="row col">
      <p>Loading...</p>
    </div>

    <div v-else-if="hasError" class="row col">
      <div class="alert alert-danger" role="alert">
        {{ error }}
      </div>
    </div>

    <table class="table table-striped">
      <thead>
      <tr>
        <th scope="col">Base Currency</th>
        <th scope="col">Quote Currency</th>
        <th scope="col">Date</th>
        <th scope="col">Rate</th>
        <th scope="col">Weight</th>
        <th scope="col">Source</th>
      </tr>
      </thead>
      <tbody>
        <tr v-if="!hasRates">
          <td colspan="6">No rates!</td>
        </tr>
        <rate v-for="rate in rates" :key="rate.id" :rate=rate />
      </tbody>
    </table>
  </div>
</template>

<script>
import Rate from "../components/Rate";

export default {
  name: "Admin",
  components: {
    Rate
  },
  data() {
    return {
      message: ""
    };
  },
  computed: {
    isLoading() {
      return this.$store.getters["rate/isLoading"];
    },
    hasError() {
      return this.$store.getters["rate/hasError"];
    },
    error() {
      return this.$store.getters["rate/error"];
    },
    hasRates() {
      return this.$store.getters["rate/hasRates"];
    },
    rates() {
      return this.$store.getters["rate/rates"];
    }
  },
  created() {
    this.$store.dispatch("rate/findAll");
  },
  methods: {
    async createRate() {
      const result = await this.$store.dispatch("rate/create", this.$data.message);
      if (result !== null) {
        this.$data.message = "";
      }
    },

    async retrieveRates() {
      const result = await this.$store.dispatch("rate/retrieve");
      if (result !== null) {
        this.$data.message = "";
      }
    }
  }
};
</script>