<template>
  <div>
    <div class="row col">
      <h1>Convertor</h1>
    </div>

    <div class="row col">
      <div class="form-row">
        <div class="form-group col-4">
          <input type="number" v-model="amount" class="form-control">
        </div>
        <div class="form-group col-4">
          <select class="form-control">
            <option>1</option>
            <option>2</option>
          </select>
        </div>
        <div class="form-group col-4">
          <select class="form-control">
            <option>1</option>
            <option>2</option>
          </select>
        </div>
        <div class="form-group col-4">
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
      amount: "0.0"
    };
  },
  computed: {
    calculated() {
      return this.amount * 2;
    }
  }
};
</script>