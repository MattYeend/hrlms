<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import StatCard from '../components/StatCard.vue';

const props = defineProps<{
	blogCount: number;
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
    <div 
        class="w-full h-full grid gap-4 p-4" 
        :class="{
            'grid-cols-3': 
                props.pendingBlogCount > 0 && props.approvedBlogCount > 0 && props.deniedBlogCount === 0,
            'grid-cols-2': props.pendingBlogCount > 0 && props.approvedBlogCount > 0 && props.deniedBlogCount > 0,
            'grid-cols-1': props.pendingBlogCount === 0 && props.approvedBlogCount === 0 && props.deniedBlogCount === 0
        }"
    >
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
	</div>
</template>