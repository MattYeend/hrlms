<script setup lang="ts">
import ErrorLayout from './ErrorLayout.vue';
</script>

<template>
    <ErrorLayout :code="503" message="Service unavailable. Please check back later." />
</template>