<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import LearningMaterialForm from '../learningMaterial/LearningMaterialForm.vue'
import { type BreadcrumbItem } from '@/types'

defineProps<{
	learningProviders: Array<{ id: number, name: string }>
    departments: Array<{ id: number, name: string }>
}>()

const breadcrumbs: BreadcrumbItem[] = [
	{ title: 'Dashboard', href: route('dashboard') },
	{ title: 'Learning Materials', href: route('learningMaterials.index') },
	{ title: 'Create', href: route('learningMaterials.create') },
]
</script>

<template>
  	<AppLayout title="Create Learning Material" :breadcrumbs="breadcrumbs">
		<Head title="Create Learning Material" />
		<div class="px-4 sm:px-6 lg:px-8 py-4 sm:py-6 lg:py-8">
	  		<h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">Create Learning Material</h1>
	  		<LearningMaterialForm 
				:is-edit="false" 
				:learningProvider="learningProviders"
                :department="departments"
			/>
		</div>
  	</AppLayout>
</template>