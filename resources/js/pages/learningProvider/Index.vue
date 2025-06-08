<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import { type BreadcrumbItem } from '@/types'

defineProps<{
	learningProviders: Array<{
		id: number
		name: string
		slug: string
		business_type: {id: number, name: string }
		first_line: string 
        post_code: string
        person_to_contact: string
        main_email_address: string
        first_phone_number: number
		is_archived: boolean
	}>
	authUser: {
		id: number
		role: { name: string }
	}
}>()

const breadcrumbs: BreadcrumbItem[] = [
	{ title: 'Dashboard', href: route('dashboard') },
	{ title: 'Learning Providers', href: route('learningProviders.index') },
]
</script>

<template>
	<AppLayout title="Learning Providers" :breadcrumbs="breadcrumbs">
		<Head title="Learning Providers" />
	
		<div class="px-4 sm:px-6 lg:px-8 py-4 sm:py-6 lg:py-8">
			<div class="flex justify-between items-center mb-6">
				<h1 class="text-3xl font-bold text-gray-900 dark:text-white">Learning Providers</h1>
				<Link 
                    v-if="['Admin', 'Super Admin'].includes(authUser.role.name)"
                    :href="route('learningProviders.create')"
					class="text-sm text-blue-600 dark:text-blue-400"
                >
					+ New Learning Provider
				</Link>
			</div>
	
			<div class="overflow-x-auto">
				<table class="min-w-full border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 rounded-md shadow-sm">
					<thead class="bg-gray-100 dark:bg-gray-700">
						<tr>
							<th class="text-left p-3">Name</th>
							<th class="text-left p-3">Business Type</th>
							<th class="text-left p-3">Address</th>
							<th class="text-left p-3">Main Contact</th>
							<th class="text-left p-3">Actions</th>
						</tr>
					</thead>
					<tbody>
						<tr 
							v-for="learningProvider in learningProviders" 
							:key="learningProvider.id" 
							class="hover:bg-gray-50 dark:hover:bg-gray-700 transition"
						>
							<td class="p-3">{{ learningProvider.name }}</td>
							<td class="p-3">{{ learningProvider.business_type?.name ?? '-' }}</td>
							<td class="p-3">{{ learningProvider?.first_line }} {{ learningProvider?.post_code }}</td>
							<td class="p-3">{{ learningProvider.person_to_contact }} {{ learningProvider.first_phone_number }} {{ learningProvider.main_email_address }}</td>
							<td class="p-3">
								<Link 
									:href="route('learningProviders.show', { learningProvider: learningProvider.slug }) + `?from=index`" 
									class="text-sm text-blue-600 dark:text-blue-400"
								>
									View
								</Link>
								<Link 
									v-if="['Admin', 'Super Admin'].includes(authUser.role.name)"
									:href="route('learningProviders.edit', { learningProvider: learningProvider.slug })" 
									class="text-sm text-blue-600 dark:text-blue-400"
								>
									Edit
								</Link>
								<Link 
                                    v-if="['Admin', 'Super Admin'].includes(authUser.role.name)"
                                    :href="route('learningProviders.destroy', { learningProvider: learningProvider.slug })"
                                    method="delete"
                                    as="button"
                                    class="text-sm text-red-600 dark:text-red-400"
                                >
                                    {{ 'Archive' }}
                                </Link>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</AppLayout>
</template>