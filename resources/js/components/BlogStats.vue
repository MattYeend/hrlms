<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import StatCard from '../components/StatCard.vue';

const props = defineProps<{
	blogCount: number;
	archivedBlogCount: number;
    approvedBlogCount: number;
    deniedBlogCount: number;
    pendingBlogCount: number;
    text: string;
	authUser: {
		id: number
		role: { name: string }
	}
}>();
</script>

<template>
	<div class="w-full h-full grid gap-4 p-4" :class="props.archivedBlogCount||approvedBlogCount||deniedBlogCount > 0 ? 'grid-cols-2' : 'grid-cols-1'">
		<Link 
            :href="route('blogs.index')"
        >
			<StatCard 
                title="Total Blogs" 
                :count="props.blogCount" 
                text="Pending and Approved blogs"
            />
		</Link>

        <Link 
            v-if="props.approvedBlogCount > 0"
            :href="route('blogs.index')"
        >
			<StatCard 
                v-if="props.approvedBlogCount > 0"
                title="Approved Blogs" 
                :count="props.approvedBlogCount" 
                text="Blogs that are approved"
            />
		</Link>

        <Link 
            v-if="props.pendingBlogCount > 0"
            :href="route('blogs.index')"
        >
			<StatCard 
                v-if="props.pendingBlogCount > 0"
                title="Pending Blogs" 
                :count="props.pendingBlogCount" 
                text="Blogs that are pending"
            />
		</Link>

        <Link 
            v-if="props.deniedBlogCount > 0 && ['Admin', 'Super Admin'].includes(props.authUser.role.name)" 
            :href="route('blogs.denied')"
        >
			<StatCard 
                v-if="props.deniedBlogCount > 0 && ['Admin', 'Super Admin'].includes(props.authUser.role.name)" 
                title="Denied Blogs" 
                :count="props.deniedBlogCount" 
                text="Blogs that have been denied"
            />
		</Link>

		<Link 
				v-if="props.archivedBlogCount > 0 && ['Admin', 'Super Admin'].includes(props.authUser.role.name)" 
				:href="route('blogs.archived')" 
		>
			<StatCard
				v-if="props.archivedBlogCount > 0 && ['Admin', 'Super Admin'].includes(props.authUser.role.name)"
				title="Archived Blogs"
				:count="props.archivedBlogCount"
                text="Archived blog posts"
			/>
		</Link>
	</div>
</template>