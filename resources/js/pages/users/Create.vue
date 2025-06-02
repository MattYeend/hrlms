<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import UserForm from '../users/UserForm.vue'
import { type BreadcrumbItem } from '@/types'

defineProps<{
	roles: Array<{ id: number; name: string }>
	departments: Array<{ id: number; name: string }>
	jobs: Array<{ id: number; job_title: string }>
}>()

const breadcrumbs: BreadcrumbItem[] = [
	{ title: 'Dashboard', href: route('dashboard') },
	{ title: 'Users', href: route('users.index') },
	{ title: 'Create', href: route('users.create') },
]
</script>

<template>
  	<AppLayout title="Create User" :breadcrumbs="breadcrumbs">
		<Head title="Create User" />
		<div class="px-4 sm:px-6 lg:px-8 py-4 sm:py-6 lg:py-8">
	  		<h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">Create User</h1>
	  		<UserForm :is-edit="false" :roles="roles" :departments="departments" :jobs="jobs" />
		</div>
  	</AppLayout>
</template>