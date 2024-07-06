
<template>
  <div v-if="errors.length > 0" class="alert alert-danger">
    <h2>{{ title }}</h2>
    <ul>
      <li v-for="error in errors" :key="error">{{ error }}</li>
    </ul>
  </div>
</template>

<script>
export default {
  name: 'FormErrors',
  props: {
    errors: Array,
    title: String
  }
};
</script>
