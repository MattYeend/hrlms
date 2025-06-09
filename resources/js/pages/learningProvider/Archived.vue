<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import { type BreadcrumbItem } from '@/types'

defineProps<{
	learningProviders: {
		data: Array<{
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
	{ title: 'Learning Providers', href: route('learningProviders.index') },
]
</script>

<template>
	<AppLayout title="Learning Providers" :breadcrumbs="breadcrumbs">
		<Head title="Learning Providers" />
	
		<div class="px-4 sm:px-6 lg:px-8 py-4 sm:py-6 lg:py-8">
			<div class="flex justify-between items-center mb-6">
				<h1 class="text-3xl font-bold text-gray-900 dark:text-white">Archived Learning Providers</h1>
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
                            v-for="learningProvider in learningProviders.data" 
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
									:href="route('learningProviders.restore', { learningProvider: learningProvider.slug })" 
									:method="'post'" 
									as="button" 
									class="text-sm text-red-600 dark:text-red-400"
								>
					  				{{ 'Restore'}}
								</Link>
							</td>
			  			</tr>
					</tbody>
		  		</table>
				<div class="mt-4 flex justify-center gap-2">
					<Link
						v-for="link in learningProviders.links"
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