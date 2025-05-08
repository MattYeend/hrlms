<script setup>
import ErrorLayout from './ErrorLayout.vue';
</script>

<template>
    <ErrorLayout :code="403" message="You do not have permission to view this page." />
</template>