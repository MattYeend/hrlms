<script setup>
import ErrorLayout from './ErrorLayout.vue';
</script>

<template>
    <ErrorLayout :code="404" message="The page you are looking for could not be found." />
</template>