<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import BlogForm from '../blogs/BlogForm.vue'
import { type BreadcrumbItem } from '@/types'

defineProps<{
	blog: {
		id: number
		title: string
		content: string
	}
}>()

const breadcrumbs: BreadcrumbItem[] = [
	{ title: 'Dashboard', href: route('dashboard') },
	{ title: 'Blogs', href: route('blogs.index') },
	{ title: 'Edit', href: '#' },
]
</script>

<template>
	<AppLayout title="Edit Blog" :breadcrumbs="breadcrumbs">
		<Head title="Edit Blog" />
		<div class="px-4 sm:px-6 lg:px-8 py-4 sm:py-6 lg:py-8">
			<h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">Edit Blog</h1>
			<BlogForm :is-edit="true" :blog="blog" />
		</div>
	</AppLayout>
</template>