<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import { type BreadcrumbItem } from '@/types'

const props = defineProps<{
	blog: {
		id: number
		title: string
		content: string
		approved: boolean
		approved_by: { id: number; name: string } | null
		is_archived: boolean
		slug: string
		created_by: { id: number; name: string }
	}
	authUser: {
		id: number
		role: { name: string }
	}
	from: 'index' | 'archived'
}>()

const breadcrumbs: BreadcrumbItem[] = [
	{ title: 'Dashboard', href: route('dashboard') },
	{ title: 'Blogs', href: route('blogs.index') },
	{ title: props.blog.title, href: '#' },
]
</script>

<template>
	<AppLayout title="Blog Details" :breadcrumbs="breadcrumbs">
		<Head title="Blog Details" />

		<div class="px-4 sm:px-6 lg:px-8 py-4 sm:py-6 lg:py-8 space-y-6">
			<h1 class="text-3xl font-bold text-gray-900 dark:text-white">Blog Details</h1>

			<div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 space-y-2">
				<p><strong>Title:</strong> {{ blog.title }}</p>
				<p><strong>Content:</strong> {{ blog.content }}</p>
				<p><strong>Approved:</strong> {{ blog.approved ? 'Yes' : 'No' }}</p>
				<p><strong>Approved By:</strong> {{ blog.approved_by?.name ?? 'Not yet approved' }}</p>
				<p><strong>Created By:</strong> {{ blog.created_by.name }}</p>
			</div>

			<div class="flex space-x-4">
				<Link :href="route('blogs.edit', blog.slug)" class="btn btn-primary">Edit</Link>
				<Link :href="from === 'archived' ? route('blogs.archived') : route('blogs.index')" class="btn btn-secondary">
					Back
				</Link>
			</div>
		</div>
	</AppLayout>
</template>