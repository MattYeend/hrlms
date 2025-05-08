<script setup>
import ErrorLayout from './ErrorLayout.vue';
</script>

<template>
    <ErrorLayout :code="500" message="Server error. We're working to fix it." />
</template>