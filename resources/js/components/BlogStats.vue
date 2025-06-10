<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import StatCard from '../components/StatCard.vue';

const props = defineProps<{
	blogCount: number;
	archivedBlogCount: number;
    text: string;
	authUser: {
		id: number
		role: { name: string }
	}
}>();
</script>

<template>
	<div class="w-full h-full grid gap-4 p-4" :class="props.archivedBlogCount > 0 ? 'grid-cols-2' : 'grid-cols-1'">
		<Link 
            :href="route('blogs.index')"
        >
			<StatCard 
                title="Total Blogs" 
                :count="blogCount" 
                text="Pending and Approved blogs "
            />
		</Link>
		<Link 
				v-if="archivedBlogCount > 0 && ['Admin', 'Super Admin'].includes(props.authUser.role.name)" 
				:href="route('blogs.archived')" 
		>
			<StatCard
				v-if="archivedBlogCount > 0 && ['Admin', 'Super Admin'].includes(props.authUser.role.name)"
				title="Archived Blogs"
				:count="archivedBlogCount"
                text="Archived blog posts"
			/>
		</Link>
	</div>
</template>