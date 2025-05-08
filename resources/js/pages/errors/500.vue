<script setup lang="ts">
import ErrorLayout from './ErrorLayout.vue';

defineProps({
    status: Number,
    message: String
});
</script>

<template>
    <ErrorLayout :code="status" :message="message" />
</template>