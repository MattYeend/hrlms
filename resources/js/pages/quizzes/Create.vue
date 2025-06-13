<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import QuizForm from '../quizzes/QuizForm.vue'
import { type BreadcrumbItem } from '@/types'

defineProps<{
    learningProviders: Array<{ id: number; name: string }>
    users?: Array<{ id: number; name: string }>
}>()

const breadcrumbs: BreadcrumbItem[] = [
	{ title: 'Dashboard', href: route('dashboard') },
	{ title: 'Quizzes', href: route('quizzes.index') },
	{ title: 'Create', href: route('quizzes.create') },
]
</script>

<template>
  	<AppLayout title="Create Quiz" :breadcrumbs="breadcrumbs">
		<Head title="Create Quiz" />
		<div class="px-4 sm:px-6 lg:px-8 py-4 sm:py-6 lg:py-8">
	  		<h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">Create Quiz</h1>
			<QuizForm 
				:is-edit="false" 
				:learning-providers="learningProviders"
				:users="users"
			/>
		</div>
  	</AppLayout>
</template>