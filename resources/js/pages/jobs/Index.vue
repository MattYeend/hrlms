<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import { type BreadcrumbItem } from '@/types'

defineProps<{
	jobs: Array<{
		id: number
		title: string
		short_code: string
		description: string | null
		department: { name: string }
		archived: boolean
		slug: string
	}>
	authUser: {
		id: number
		role: { name: string }
	}
}>()

const breadcrumbs: BreadcrumbItem[] = [
	{ title: 'Dashboard', href: route('dashboard') },
	{ title: 'Jobs', href: route('jobs.index') },
]
</script>

<template>
	<AppLayout title="Jobs" :breadcrumbs="breadcrumbs">
		<Head title="Jobs" />
	
		<div class="px-4 sm:px-6 lg:px-8 py-4 sm:py-6 lg:py-8">
			<div class="flex justify-between items-center mb-6">
				<h1 class="text-3xl font-bold text-gray-900 dark:text-white">Jobs</h1>
				<Link :href="route('jobs.create')" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md shadow-sm">
					+ New Job
				</Link>
			</div>
	
			<div class="overflow-x-auto">
				<table class="min-w-full border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 rounded-md shadow-sm">
					<thead class="bg-gray-100 dark:bg-gray-700">
						<tr>
							<th class="text-left p-3">Title</th>
							<th class="text-left p-3">Short Code</th>
							<th class="text-left p-3">Description</th>
							<th class="text-left p-3">Department</th>
							<th class="text-left p-3">Actions</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="job in jobs" :key="job.id" class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
							<td class="p-3">{{ job.title }}</td>
							<td class="p-3">{{ job.short_code }}</td>
							<td class="p-3">{{ job?.description ?? '-' }}</td>
							<td class="p-3">{{ job.department?.name ?? '-' }}</td>
							<td class="p-3">
								<Link :href="route('users.show', { slug: job.slug }) + `?from=index`" class="text-blue-600 dark:text-blue-400 hover:underline">View</Link>
								<span v-if="['Admin', 'Super Admin'].includes(authUser.role.name)">| 
									<Link :href="route('users.edit', job.slug)" class="text-blue-600 dark:text-blue-400 hover:underline">Edit</Link>
								</span>
								<span v-if="['Admin', 'Super Admin'].includes(authUser.role.name)">|
									<Link :href="route('users.destroy', job.slug)" :method="'delete'" as="button" class="text-red-600 dark:text-red-400 hover:underline" >
										{{ 'Archive' }}
									</Link>
								</span>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</AppLayout>
</template>