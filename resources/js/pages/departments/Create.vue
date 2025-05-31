<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import DepartmentForm from '../departments/DepartmentForm.vue'
import { type BreadcrumbItem } from '@/types'

const breadcrumbs: BreadcrumbItem[] = [
	{ title: 'Dashboard', href: route('dashboard') },
	{ title: 'Departments', href: route('departments.index') },
	{ title: 'Create', href: route('departments.create') },
]

defineProps({
	department: {
		type: Object,
		required: false,
		default: () => ({
			name: '',
			description: '',
			is_default: false,
			dept_lead: '',
		}),
	},
	users: {
		type: Array,
		required: true,
	},
})
</script>

<template>
	<AppLayout title="Create Department" :breadcrumbs="breadcrumbs">
		<Head title="Create Department" />

		<div class="px-4 sm:px-6 lg:px-8 py-4 sm:py-6 lg:py-8">
			<h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">Create Department</h1>
			<DepartmentForm :is-edit="false" :department="department" :users="users" />
		</div>
	</AppLayout>
</template>