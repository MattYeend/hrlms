<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import { type BreadcrumbItem } from '@/types'

defineProps<{
	jobs: {
		data: Array<{
			id: number
			job_title: string
			short_code: string
			description: string 
			department: { name: string }
			is_archived: boolean
			slug: string
		}>
		current_page: number
		last_page: number
		links: Array<any>
	}
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
				<!-- <Link :href="route('jobs.create')" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md shadow-sm">
					+ New Job
				</Link> -->
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
						<tr 
							v-for="job in jobs.data" 
							:key="job.id" 
							class="hover:bg-gray-50 dark:hover:bg-gray-700 transition"
						>
							<td class="p-3">{{ job.job_title }}</td>
							<td class="p-3">{{ job.short_code }}</td>
							<td class="p-3">{{ job?.description ?? '-' }}</td>
							<td class="p-3">{{ job.department?.name ?? '-' }}</td>
							<td class="p-3">
								<Link 
									:href="route('jobs.show', { job: job.slug }) + `?from=index`" 
									class="text-sm text-blue-600 dark:text-blue-400"
								>
									View
								</Link>
								<!-- <Link 
									v-if="['Admin', 'Super Admin'].includes(authUser.role.name)"
									:href="route('jobs.edit', { job: job.slug })" 
									class="text-sm text-blue-600 dark:text-blue-400"
								>
									Edit
								</Link> -->
								<Link 
									v-if="['Admin', 'Super Admin'].includes(authUser.role.name)"
									:href="route('jobs.destroy', { job: job.slug })"
									 :method="'delete'" 
									 as="button" 
									 class="text-sm text-red-600 dark:text-red-400"
									>
									{{ 'Archive' }}
								</Link>
							</td>
						</tr>
					</tbody>
				</table>
				<div class="mt-4 flex justify-center gap-2">
					<Link
						v-for="link in jobs.links"
						:key="link.label"
						:href="link.url || '#'"
						v-html="link.label"
						class="px-3 py-1 rounded text-sm"
						:class="{
							'bg-blue-500 text-white': link.active,
							'text-gray-600 dark:text-gray-300': !link.active,
							'pointer-events-none opacity-50': !link.url
						}"
					/>
				</div>
			</div>
		</div>
	</AppLayout>
</template>