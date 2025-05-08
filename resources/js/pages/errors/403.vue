<script setup lang="ts">
import ErrorLayout from './ErrorLayout.vue';
</script>

<template>
    <ErrorLayout :code="403" message="You do not have permission to view this page." />
</template>