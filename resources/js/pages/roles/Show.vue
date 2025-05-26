<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import { type BreadcrumbItem } from '@/types'

const props = defineProps<{
  role: {
    id: number
    name: string
    slug: string
    description: string
    is_default: boolean
  }
}>()

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Dashboard', href: route('dashboard') },
  { title: 'Roles', href: route('roles.index') },
  { title: 'Details', href: '#' },
]
</script>

<template>
  <AppLayout title="Role Details" :breadcrumbs="breadcrumbs">
    <Head title="Role Details" />

    <div class="px-4 sm:px-6 lg:px-8 py-4 sm:py-6 lg:py-8 space-y-6">
      <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Role Details</h1>

      <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 space-y-2">
        <p><strong>Name:</strong> {{ props.role.name }}</p>
        <p><strong>Description:</strong> {{ props.role.description }}</p>
        <p><strong>Slug:</strong> {{ props.role.slug }}</p>
        <p><strong>Default:</strong> {{ props.role.is_default ? 'Yes' : 'No' }}</p>
      </div>

      <div class="flex space-x-4">
        <Link :href="route('roles.index')" class="btn btn-secondary">Back</Link>
      </div>
    </div>
  </AppLayout>
</template>