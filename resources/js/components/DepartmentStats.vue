<script setup lang="ts">
import StatCard from '@/components/StatCard.vue';

const props = defineProps<{
	departmentCount: number;
	archivedDepartmentCount: number;
	authUser: {
		id: number
		role: { name: string }
	}
}>();
</script>

<template>
	<div class="w-full h-full grid gap-4 p-4" :class="props.archivedDepartmentCount > 0 ? 'grid-cols-2' : 'grid-cols-1'">
		<StatCard title="Departments" :count="departmentCount" />
		<StatCard
			v-if="archivedDepartmentCount > 0 && ['Admin', 'Super Admin'].includes(props.authUser.role.name)"
			title="Archived Departments"
			:count="archivedDepartmentCount"
		/>
	</div>
</template>