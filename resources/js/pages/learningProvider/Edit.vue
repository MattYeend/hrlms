<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import LearningProviderForm from '../learningProvider/LearningProviderForm.vue'
import { type BreadcrumbItem } from '@/types'

defineProps<{
	learningProvider: Array<{
		id: number
		name: string
        business_type_id: number | null
		slug: string
		first_line: string 
        post_code: string
        person_to_contact: string
        main_email_address: string
        first_phone_number: number
		is_archived: boolean
	}>
	businessTypes: Array<{ id: number, name: string }>
}>()

const breadcrumbs: BreadcrumbItem[] = [
	{ title: 'Dashboard', href: route('dashboard') },
	{ title: 'Learning Providers', href: route('learningProviders.index') },
	{ title: 'Edit', href: '#' },
]
</script>

<template>
	<AppLayout title="Edit Learning Provider" :breadcrumbs="breadcrumbs">
		<Head title="Edit Learning Provider" />
		<div class="px-4 sm:px-6 lg:px-8 py-4 sm:py-6 lg:py-8">
			<h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">Edit Learning Provider</h1>
			<LearningProviderForm 
				:is-edit="true"  
                :learningProvider="learningProvider"
				:businessTypes="businessTypes"
			/>
		</div>
	</AppLayout>
</template>