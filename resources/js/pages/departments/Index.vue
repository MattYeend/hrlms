<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import { type BreadcrumbItem } from '@/types'

defineProps<{
	departments: Array<{
		id: number
		name: string
		slug: string
		dept_lead?: { id: number, name: string }
		archived: boolean
		users_count: number
	}>
	authUser: {
		id: number
		role: { name: string }
	}
}>()

const breadcrumbs: BreadcrumbItem[] = [
	{ title: 'Dashboard', href: route('dashboard') },
	{ title: 'Departments', href: route('departments.index') },
]
</script>

<template>
	<AppLayout title="Departments" :breadcrumbs="breadcrumbs">
		<Head title="Departments" />

		<div class="px-4 sm:px-6 lg:px-8 py-4 sm:py-6 lg:py-8">
			<div class="flex justify-between items-center mb-6">
				<h1 class="text-3xl font-bold text-gray-900 dark:text-white">Departments</h1>
				<Link :href="route('departments.create')" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md shadow-sm" >
					+ New Department
				</Link>
			</div>

			<div class="overflow-x-auto">
				<table class="min-w-full border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 rounded-md shadow-sm">
					<thead class="bg-gray-100 dark:bg-gray-700">
						<tr>
							<th class="text-left p-3">Name</th>
							<th class="text-left p-3">Lead</th>
							<th class="text-left p-3">Actions</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="department in departments" :key="department.id" class="hover:bg-gray-50 dark:hover:bg-gray-700 transition" >
							<td class="p-3">{{ department.name }}</td>
							<td class="p-3">{{ department.dept_lead?.name || '—' }}</td>
							<td class="p-3">
								<Link :href="route('departments.show', { slug: department.slug }) + `?from=index`" class="text-blue-600 dark:text-blue-400 hover:underline">
									View
								</Link>
								<span v-if="['Admin', 'Super Admin'].includes(authUser.role.name)">|
									<Link :href="route('departments.edit', department.slug)" class="text-blue-600 dark:text-blue-400 hover:underline">
										Edit
									</Link>
								</span>
								<span v-if=" ['Admin', 'Super Admin'].includes(authUser.role.name) && department.users_count === 0 ">|
									<Link :href="route('departments.destroy', department.slug)" :method="'delete'" as="button" class="text-red-600 dark:text-red-400 hover:underline" >
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