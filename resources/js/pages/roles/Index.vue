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
    is_active: boolean
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

    <div>
      <h1 class="text-3xl font-bold mb-6 text-gray-900 dark:text-white">Roles</h1>

      <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 rounded-md shadow-sm">
          <thead class="bg-gray-100 dark:bg-gray-700">
            <tr>
              <th class="text-left p-3 border-b border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-200">Name</th>
              <th class="text-left p-3 border-b border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-200">Slug</th>
              <th class="text-left p-3 border-b border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-200">Active</th>
              <th class="text-left p-3 border-b border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-200">Default</th>
              <th class="text-left p-3 border-b border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-200">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="role in props.roles"
              :key="role.id"
              class="hover:bg-gray-50 dark:hover:bg-gray-700 transition"
            >
              <td class="p-3 border-b border-gray-200 dark:border-gray-600 text-gray-800 dark:text-gray-100">{{ role.name }}</td>
              <td class="p-3 border-b border-gray-200 dark:border-gray-600 text-gray-800 dark:text-gray-100">{{ role.slug }}</td>
              <td class="p-3 border-b border-gray-200 dark:border-gray-600 text-gray-800 dark:text-gray-100">{{ role.is_active ? 'Yes' : 'No' }}</td>
              <td class="p-3 border-b border-gray-200 dark:border-gray-600 text-gray-800 dark:text-gray-100">{{ role.is_default ? 'Yes' : 'No' }}</td>
              <td class="p-3 border-b border-gray-200 dark:border-gray-600">
                <Link
                  :href="route('roles.show', role.id)"
                  class="text-blue-600 dark:text-blue-400 hover:underline"
                >
                  View
                </Link>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </AppLayout>
</template>