<template>
	<ErrorLayout :code="429" message="Too many requests. Please try again later." />
</template>
	
<script setup lang="ts">
	import ErrorLayout from './ErrorLayout.vue';
</script>