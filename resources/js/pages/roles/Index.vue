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
      <h1 class="text-3xl font-bold mb-6">Roles</h1>

      <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 rounded-md shadow-sm">
          <thead class="bg-gray-100">
            <tr>
              <th class="text-left p-3 border-b">Name</th>
              <th class="text-left p-3 border-b">Slug</th>
              <th class="text-left p-3 border-b">Active</th>
              <th class="text-left p-3 border-b">Default</th>
              <th class="text-left p-3 border-b">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="role in props.roles"
              :key="role.id"
              class="hover:bg-gray-50 transition"
            >
              <td class="p-3 border-b">{{ role.name }}</td>
              <td class="p-3 border-b">{{ role.slug }}</td>
              <td class="p-3 border-b">{{ role.is_active ? 'Yes' : 'No' }}</td>
              <td class="p-3 border-b">{{ role.is_default ? 'Yes' : 'No' }}</td>
              <td class="p-3 border-b">
                <Link
                  :href="route('roles.show', role.id)"
                  class="text-blue-600 hover:underline"
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