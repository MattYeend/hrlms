<script setup lang="ts">
import StatCard from '@/components/StatCard.vue';

const props = defineProps<{
	departmentCount: number;
	archivedDepartmentCount: number;
}>();
</script>

<template>
	<div class="w-full h-full grid gap-4 p-4" :class="props.archivedDepartmentCount > 0 ? 'grid-cols-2' : 'grid-cols-1'">
		<StatCard title="Active Departments" :count="departmentCount" />
		<StatCard
			v-if="archivedDepartmentCount > 0"
			title="Archived Departments"
			:count="archivedDepartmentCount"
		/>
	</div>
</template>