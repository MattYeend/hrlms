<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import StatCard from '../components/StatCard.vue';

const props = defineProps<{
	departmentCount: number;
	archivedDepartmentCount: number;
	text: string;
	authUser: {
		id: number
		role: { name: string }
	}
}>();
</script>

<template>
	<div class="w-full h-full grid gap-4 p-4" :class="props.archivedDepartmentCount > 0 ? 'grid-cols-2' : 'grid-cols-1'">
		<Link 
            :href="route('departments.index')"
        >
			<StatCard 
				title="Departments"
				:count="departmentCount" 
				text="All active departments"
			/>
		</Link>
		<Link 
			v-if="archivedDepartmentCount > 0 && ['Admin', 'Super Admin'].includes(props.authUser.role.name)" 
			:href="route('departments.archived')" 
		>
			<StatCard
				v-if="archivedDepartmentCount > 0 && ['Admin', 'Super Admin'].includes(props.authUser.role.name)"
				title="Archived Departments"
				:count="archivedDepartmentCount"
				text="Archived departments"
			/>
		</Link>
	</div>
</template>