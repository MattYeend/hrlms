<template>
	<ErrorLayout :code="403" message="Forbidden — You do not have access." />
</template>

<script setup lang="ts">
	import ErrorLayout from './ErrorLayout.vue';
</script>