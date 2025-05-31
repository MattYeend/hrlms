<template>
	<ErrorLayout :code="404" message="Page not found." />
</template>
  
<script setup lang="ts">
	import ErrorLayout from './ErrorLayout.vue';
</script>