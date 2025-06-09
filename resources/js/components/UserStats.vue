<script setup lang="ts">
import StatCard from '@/components/StatCard.vue';

const props = defineProps<{
	userCount: number;
	archivedUserCount: number;
	authUser: {
		id: number
		role: { name: string }
	}
}>();
</script>

<template>
	<div class="w-full h-full grid gap-4 p-4" :class="props.archivedUserCount > 0 ? 'grid-cols-2' : 'grid-cols-1'">
		<StatCard title="Users" :count="userCount" />
		<StatCard
			v-if="archivedUserCount > 0 && ['Admin', 'Super Admin'].includes(props.authUser.role.name)"
			title="Archived Users"
			:count="archivedUserCount"
		/>
	</div>
</template>