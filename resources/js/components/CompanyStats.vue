<script setup lang="ts">
import StatCard from '@/components/StatCard.vue';

const props = defineProps<{
	companyCount: number;
	archivedCompanyCount: number;
}>();
</script>

<template>
	<div class="w-full h-full grid gap-4 p-4" :class="props.archivedCompanyCount > 0 ? 'grid-cols-2' : 'grid-cols-1'">
		<StatCard title="Active Companies" :count="companyCount" />
		<StatCard
			v-if="archivedCompanyCount > 0"
			title="Archived Companies"
			:count="archivedCompanyCount"
		/>
	</div>
</template>