<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import { type BreadcrumbItem } from '@/types'

defineProps<{
	learningMaterials: {
		data: Array<{
			id: number
			title: string
			slug: string
            key_objectives: string
            description: string
            file_path: string
			learning_provider: {id: number, name: string }
            department: {id: number, name: string }
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
	{ title: 'Learning Materials', href: route('learningMaterials.index') },
]

const truncate = (text: string, length = 100) => {
	return text.length > length ? text.slice(0, length) + '…' : text
}
</script>

<template>
	<AppLayout title="Learning Materials" :breadcrumbs="breadcrumbs">
		<Head title="Learning Materials" />
	
		<div class="px-4 sm:px-6 lg:px-8 py-4 sm:py-6 lg:py-8">
			<div class="flex justify-between items-center mb-6">
				<h1 class="text-3xl font-bold text-gray-900 dark:text-white">Archived Learning Materials</h1>
			</div>
  
			<div class="overflow-x-auto">
				<table class="min-w-full border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 rounded-md shadow-sm">
					<thead class="bg-gray-100 dark:bg-gray-700">
						<tr>
							<th class="text-left p-3">Title</th>
							<th class="text-left p-3">Key Objectives</th>
							<th class="text-left p-3">Description</th>
                            <th class="text-left p-3">Learning Provider</th>
                            <th class="text-left p-3">Department</th>
							<th class="text-left p-3">Actions</th>
						</tr>
					</thead>
					<tbody>
						<tr 
                            v-for="learningMaterial in learningMaterials.data" 
                            :key="learningMaterial.id" 
							class="hover:bg-gray-50 dark:hover:bg-gray-700 transition"
						>
                            <td class="p-3">{{ learningMaterial.title }}</td>
							<td class="p-3">{{ truncate(learningMaterial.key_objectives, 100)?? '-' }}</td>
							<td class="p-3">{{ truncate(learningMaterial.description, 100)?? '-' }}</td>
							<td class="p-3">{{ learningMaterial.learning_provider?.name ?? '-' }}</td>
                            <td class="p-3">{{ learningMaterial.department?.name ?? '-' }}</td>
							<td class="p-3">
								<Link 
									:href="route('learningMaterials.show', { learningMaterial: learningMaterial.slug }) + `?from=archived`" 
									class="text-sm text-blue-600 dark:text-blue-400"
								>
									View
								</Link>
								<Link 
									v-if="['Admin', 'Super Admin'].includes(authUser.role.name)"
									:href="route('learningMaterials.restore', { learningMaterial: learningMaterial.slug })" 
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
						v-for="link in learningMaterials.links"
						:key="link.label"
						:href="link.url || '#'"
						class="px-3 py-1 rounded text-sm"
						:class="{
							'bg-blue-500 text-white': link.active,
							'text-gray-600 dark:text-gray-300': !link.active,
							'pointer-events-none opacity-50': !link.url
						}"
					>
						<span v-html="link.label" />
					</Link>
				</div>
			</div>
	  	</div>
	</AppLayout>
</template>