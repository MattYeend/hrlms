<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import { type BreadcrumbItem } from '@/types'

defineProps<{
	users: Array<{
		id: number
		name: string
		email: string
		role: { name: string }
		department: { name: string }
		job: { job_title: string}
		is_archived: boolean
		slug: string
	}>
	authUser: {
		id: number
		role: { name: string }
	}
}>()

const breadcrumbs: BreadcrumbItem[] = [
	{ title: 'Dashboard', href: route('dashboard') },
	{ title: 'Users', href: route('users.index') },
]
</script>

<template>
	<AppLayout title="Users" :breadcrumbs="breadcrumbs">
		<Head title="Users" />
	
		<div class="px-4 sm:px-6 lg:px-8 py-4 sm:py-6 lg:py-8">
			<div class="flex justify-between items-center mb-6">
				<h1 class="text-3xl font-bold text-gray-900 dark:text-white">Archived Users</h1>
			</div>
  
			<div class="overflow-x-auto">
				<table class="min-w-full border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 rounded-md shadow-sm">
					<thead class="bg-gray-100 dark:bg-gray-700">
						<tr>
							<th class="text-left p-3">Name</th>
							<th class="text-left p-3">Email</th>
							<th class="text-left p-3">Role</th>
							<th class="text-left p-3">Department</th>
							<th class="text-left p-3">Job</th>
							<th class="text-left p-3">Actions</th>
						</tr>
					</thead>
					<tbody>
						<tr 
							v-for="user in users" 
							:key="user.id" 
							class="hover:bg-gray-50 dark:hover:bg-gray-700 transition"
						>
							<td class="p-3">{{ user.name }}</td>
							<td class="p-3">{{ user.email }}</td>
							<td class="p-3">{{ user.role?.name ?? '-' }}</td>
							<td class="p-3">{{ user.department?.name ?? '-' }}</td>
							<td class="p-3">{{ user.job?.job_title ?? '-' }}</td>
							<td class="p-3">
				  				<Link 
									:href="route('users.show', { slug: user.slug })  + `?from=archived`" 
									class="text-sm text-blue-600 dark:text-blue-400 hover:underline"
								>
									View
								</Link>
								<Link 
									v-if="['Admin', 'Super Admin'].includes(authUser.role.name) && authUser.id !== user.id"
									:href="route('users.restore', user.slug)"
									:method="'post'" 
									as="button" 
									class="text-sm text-red-600 dark:text-red-400 hover:underline"
								>
					  				{{ 'Restore'}}
								</Link>
							</td>
			  			</tr>
					</tbody>
		  		</table>
			</div>
	  	</div>
	</AppLayout>
</template>