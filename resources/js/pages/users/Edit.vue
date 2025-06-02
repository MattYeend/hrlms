<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import UserForm from '../users/UserForm.vue'
import { type BreadcrumbItem } from '@/types'

defineProps<{
	user: {
		id: number
		name: string
		email: string
		role: { id: number; name: string } | null
		department: { id: number; name: string } | null
		jobs: { id: number; job_title: string } | null
	}
	roles: Array<{ id: number; name: string }>
	departments: Array<{ id: number; name: string }>
	jobs: Array<{ id: number; job_title: string }>
}>()

const breadcrumbs: BreadcrumbItem[] = [
	{ title: 'Dashboard', href: route('dashboard') },
	{ title: 'Users', href: route('users.index') },
	{ title: 'Edit', href: '#' },
]
</script>

<template>
	<AppLayout title="Edit User" :breadcrumbs="breadcrumbs">
		<Head title="Edit User" />
		<div class="px-4 sm:px-6 lg:px-8 py-4 sm:py-6 lg:py-8">
			<h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">Edit User</h1>
			<UserForm :is-edit="true" :user="user" :roles="roles" :departments="departments" :jobs="jobs" />
		</div>
	</AppLayout>
</template>