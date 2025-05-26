<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import { type BreadcrumbItem } from '@/types'

defineProps<{
  department: Record<string, any>
}>()

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Dashboard', href: route('dashboard') },
  { title: 'Departments', href: route('departments.index') },
  { title: 'Details', href: '#' },
]
</script>

<template>
  <AppLayout title="Department Details" :breadcrumbs="breadcrumbs">
    <Head title="Department Details" />

    <div class="px-4 sm:px-6 lg:px-8 py-4 sm:py-6 lg:py-8 space-y-6">
      <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Department Details</h1>

      <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 space-y-2">
        <p><strong>Name:</strong> {{ department.name }}</p>
        <p><strong>Slug:</strong> {{ department.slug }}</p>
        <p><strong>Description:</strong> {{ department.description }}</p>
        <p><strong>Default:</strong> {{ department.is_default ? 'Yes' : 'No' }}</p>
      </div>

      <div class="flex space-x-4">
        <Link :href="route('departments.edit', department.id)" class="btn btn-primary">Edit</Link>
        <Link :href="route('departments.index')" class="btn btn-secondary">Back</Link>
      </div>
    </div>
  </AppLayout>
</template>