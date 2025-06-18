<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import LearningMaterialForm from '../learningMaterial/LearningMaterialForm.vue'
import { type BreadcrumbItem } from '@/types'

defineProps<{
    learningMaterial: {
		id: number
		title: string
		slug: string
        key_objectives: string
        description: string
        file_path: string
        learning_provider_id: number | null
        department_id: number | null
		is_archived: boolean
	}
	learningProviders: Array<{ id: number, name: string }>
    departments: Array<{ id: number, name: string }>
}>()

const breadcrumbs: BreadcrumbItem[] = [
	{ title: 'Dashboard', href: route('dashboard') },
	{ title: 'Learning Material', href: route('learningMaterials.index') },
	{ title: 'Edit', href: '#' },
]
</script>

<template>
	<AppLayout title="Edit Learning Material" :breadcrumbs="breadcrumbs">
		<Head title="Edit Learning Material" />
		<div class="px-4 sm:px-6 lg:px-8 py-4 sm:py-6 lg:py-8">
			<h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">Edit Learning Material</h1>
			<LearningMaterialForm 
				:is-edit="true"  
                :learningMaterial="learningMaterial"
                :learningProvider="learningProviders"
                :department="departments"
			/>
		</div>
	</AppLayout>
</template>