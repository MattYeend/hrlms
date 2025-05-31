<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import DepartmentForm from '../departments/DepartmentForm.vue'
import { type BreadcrumbItem } from '@/types'

defineProps<{
	department: Record<string, any>
  	users: Array<{ id: number, name: string }>
}>()

const breadcrumbs: BreadcrumbItem[] = [
  	{ title: 'Dashboard', href: route('dashboard') },
  	{ title: 'Departments', href: route('departments.index') },
  	{ title: 'Edit', href: '#' },
]
</script>

<template>
  	<AppLayout title="Edit Department" :breadcrumbs="breadcrumbs">
    	<Head title="Edit Department" />

	    <div class="px-4 sm:px-6 lg:px-8 py-4 sm:py-6 lg:py-8">
      		<h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">Edit Department</h1>
	      	<DepartmentForm :is-edit="true" :department="department" :users="users" />
    	</div>
  </AppLayout>
</template>