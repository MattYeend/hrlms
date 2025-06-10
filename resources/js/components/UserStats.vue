<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import StatCard from '../components/StatCard.vue';

const props = defineProps<{
	userCount: number;
	archivedUserCount: number;
	text: string;
	authUser: {
		id: number
		role: { name: string }
	}
}>();
</script>

<template>
	<div class="w-full h-full grid gap-4 p-4" :class="props.archivedUserCount > 0 ? 'grid-cols-2' : 'grid-cols-1'">
		<Link 
            :href="route('users.index')"
        >
			<StatCard 
				title="Users" 
				:count="userCount" 
				text="All active users"
			/>
		</Link>
		<Link 
				v-if="archivedUserCount > 0 && ['Admin', 'Super Admin'].includes(props.authUser.role.name)" 
				:href="route('users.archived')" 
		>
			<StatCard
				v-if="archivedUserCount > 0 && ['Admin', 'Super Admin'].includes(props.authUser.role.name)"
				title="Archived Users"
				:count="archivedUserCount"
				text="Archived users"
			/>
		</Link>
	</div>
</template>