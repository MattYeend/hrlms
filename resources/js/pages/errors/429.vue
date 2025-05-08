<script setup lang="ts">
import ErrorLayout from './ErrorLayout.vue';
</script>

<template>
    <ErrorLayout :code="429" message="Too many requests. Please slow down." />
</template>