<script setup lang="ts">
import StatCard from '../components/StatCard.vue';

const props = defineProps<{
	learningProviderCount: number;
	archivedLearningProviderCount: number;
	authUser: {
		id: number
		role: { name: string }
	}
}>();
</script>

<template>
	<div class="w-full h-full grid gap-4 p-4" :class="props.archivedLearningProviderCount > 0 ? 'grid-cols-2' : 'grid-cols-1'">
		<StatCard title="Learning Providers" :count="learningProviderCount" />
		<StatCard
			v-if="archivedLearningProviderCount > 0 && ['Admin', 'Super Admin'].includes(props.authUser.role.name)"
			title="Archived Learning Providers"
			:count="archivedLearningProviderCount"
		/>
	</div>
</template>