<template>
  <tr>
    <td>
      {{ rate.baseCurrency }}
    </td>
    <td>
      {{ rate.quoteCurrency }}
    </td>
    <td>
      {{ rate.fromDate | formatDate }}
    </td>
    <td>
      {{ rate.rate }}
    </td>
    <td>
      {{ rate.weight }}
    </td>
    <td>
      {{ rate.source }}
    </td>
  </tr>
</template>

<script>

export default {
  name: "Rate",
  props: {
    rate: {
      type: Object,
      required: true,
    }
  }
};
</script>