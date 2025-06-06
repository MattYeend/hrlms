<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import BlogForm from '../blogs/BlogForm.vue'
import { type BreadcrumbItem } from '@/types'

defineProps<{
	// roles: Array<{ id: number; name: string }>
	// departments: Array<{ id: number; name: string }>
	// jobs: Array<{ id: number; job_title: string }>
}>()

const breadcrumbs: BreadcrumbItem[] = [
	{ title: 'Dashboard', href: route('dashboard') },
	{ title: 'Blogs', href: route('blogs.index') },
	{ title: 'Create', href: route('Blogs.create') },
]
</script>

<template>
  	<AppLayout title="Create Blog" :breadcrumbs="breadcrumbs">
		<Head title="Create Blog" />
		<div class="px-4 sm:px-6 lg:px-8 py-4 sm:py-6 lg:py-8">
	  		<h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">Create User</h1>
	  		<BlogForm :is-edit="false" />
		</div>
  	</AppLayout>
</template>