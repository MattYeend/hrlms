<template>
	<ErrorLayout :code="status" :message="message" />
</template>
  
<script setup lang="ts">
	import ErrorLayout from './ErrorLayout.vue';
	
	defineProps<{
		status: number;
		message: string;
	}>();
</script>