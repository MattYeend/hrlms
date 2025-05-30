<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import { type BreadcrumbItem } from '@/types'

const props = defineProps<{
    roles: {
        id: number
        name: string
        slug: string
        description: string
        is_default: boolean
    }[]
}>()

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: route('dashboard') },
    { title: 'Roles', href: route('roles.index') },
]
</script>

<template>
    <AppLayout title="Roles" :breadcrumbs="breadcrumbs">
      <Head title="Roles" />
  
      <div class="px-4 sm:px-6 lg:px-8 py-4 sm:py-6 lg:py-8">
        <div class="flex justify-between items-center mb-6">
          <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Roles</h1>
        </div>
  
        <div class="overflow-x-auto">
          <table class="min-w-full border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 rounded-md shadow-sm">
            <thead class="bg-gray-100 dark:bg-gray-700">
              <tr>
                <th class="text-left p-3">Name</th>
                <th class="text-left p-3">Default</th>
                <th class="text-left p-3">Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="role in props.roles"
                :key="role.id"
                class="hover:bg-gray-50 dark:hover:bg-gray-700 transition"
              >
                <td class="p-3">{{ role.name }}</td>
                <td class="p-3">{{ role.is_default ? 'Yes' : 'No' }}</td>
                <td class="p-3 space-x-2">
                  <Link :href="route('roles.show', role.slug)" class="text-blue-600 dark:text-blue-400 hover:underline">View</Link>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </AppLayout>
  </template>