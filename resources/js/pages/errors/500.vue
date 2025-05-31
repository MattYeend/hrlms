<template>
	<ErrorLayout :code="500" message="Internal server error. Something went wrong." />
</template>
  
<script setup lang="ts">
	import ErrorLayout from './ErrorLayout.vue';
</script>