<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import LearningProviderForm from '../learningProvider/LearningProviderForm.vue'
import { type BreadcrumbItem } from '@/types'

defineProps<{
	businessTypes: Array<{ id: number, name: string }>
}>()

const breadcrumbs: BreadcrumbItem[] = [
	{ title: 'Dashboard', href: route('dashboard') },
	{ title: 'Learning Providers', href: route('learningProviders.index') },
	{ title: 'Create', href: route('learningProviders.create') },
]
</script>

<template>
  	<AppLayout title="Create Learning Provider" :breadcrumbs="breadcrumbs">
		<Head title="Create Learning Provider" />
		<div class="px-4 sm:px-6 lg:px-8 py-4 sm:py-6 lg:py-8">
	  		<h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">Create Learning Provider</h1>
	  		<LearningProviderForm 
				:is-edit="false" 
				:businessTypes="businessTypes"
			/>
		</div>
  	</AppLayout>
</template>