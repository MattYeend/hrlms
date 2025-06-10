<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import StatCard from '../components/StatCard.vue';

const props = defineProps<{
	learningProviderCount: number;
	archivedLearningProviderCount: number;
	text: string;
	authUser: {
		id: number
		role: { name: string }
	}
}>();
</script>

<template>
	<div class="w-full h-full grid gap-4 p-4" :class="props.archivedLearningProviderCount > 0 ? 'grid-cols-2' : 'grid-cols-1'">
        <Link 
            :href="route('learningProviders.index')"
        >
    		<StatCard
				title="Learning Providers" 
				:count="learningProviderCount"
				text="Active learning providers"
			/>
        </Link> 
        <Link 
                v-if="archivedLearningProviderCount > 0 && ['Admin', 'Super Admin'].includes(props.authUser.role.name)" 
				:href="route('learningProviders.archived')" 
		>
            <StatCard
			    v-if="archivedLearningProviderCount > 0 && ['Admin', 'Super Admin'].includes(props.authUser.role.name)"
    			title="Archived Learning Providers"
	    		:count="archivedLearningProviderCount"
				text="Archived learning providers"
            />
        </Link>
	</div>
</template>