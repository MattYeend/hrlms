<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import JobForm from '../jobs/JobForm.vue'
import { type BreadcrumbItem } from '@/types'

defineProps<{
	job: {
		id: number
		job_title: string
		short_code: string
        description: string | null
		department: { id: number; name: string } | null
	}
	departments: Array<{ id: number; name: string }>
}>()

const breadcrumbs: BreadcrumbItem[] = [
	{ title: 'Dashboard', href: route('dashboard') },
	{ title: 'Jobs', href: route('jobs.index') },
	{ title: 'Edit', href: '#' },
]
</script>

<template>
	<AppLayout title="Edit Job" :breadcrumbs="breadcrumbs">
		<Head title="Edit Job" />
		<div class="px-4 sm:px-6 lg:px-8 py-4 sm:py-6 lg:py-8">
			<h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">Edit Job</h1>
			<JobForm 
				:is-edit="true" 
				:job="job" 
				:departments="departments"
			/>
		</div>
	</AppLayout>
</template>