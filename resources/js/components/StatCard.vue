<script setup lang="ts">
defineProps<{
	title: string;
	count: number;
	text: string;
}>();
</script>

<template>
	<div class="flex flex-col justify-between p-4 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border bg-white dark:bg-gray-800 shadow w-full h-full">
		<p class="text-lg font-semibold text-gray-700 dark:text-gray-100">{{ title }}</p>
		<p class="text-2xl font-bold text-gray-900 dark:text-white">{{ count }}</p>
		<p class="text-xs font-bold text-gray-900 dark:text-white">{{ text }}</p>
	</div>
</template>