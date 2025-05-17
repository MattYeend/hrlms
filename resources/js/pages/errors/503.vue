<template>
    <ErrorLayout :code="503" message="Service Unavailable. Please check back later." />
</template>
  
<script setup lang="ts">
  import ErrorLayout from './ErrorLayout.vue';
</script>