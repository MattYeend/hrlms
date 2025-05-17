<template>
    <ErrorLayout :code="status" :message="message" />
</template>
  
<script setup lang="ts">
  import ErrorLayout from './ErrorLayout.vue';
  import { Head } from '@inertiajs/vue3';
  
  defineProps<{
    status: number;
    message: string;
  }>();
</script>