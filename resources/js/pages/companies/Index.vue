<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import { type BreadcrumbItem } from '@/types'

defineProps<{
  companies: Array<{
        id: number
        name: string
        slug: string
        email: string | null
        is_default: boolean
        archived: boolean
  }>
    authUser: {
        id: number
        role: { name: string }
    }
}>()

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: route('dashboard') },
    { title: 'Companies', href: route('companies.index') },
]
</script>

<template>
  <AppLayout title="Companies" :breadcrumbs="breadcrumbs">
    <Head title="Companies" />

    <div class="px-4 sm:px-6 lg:px-8 py-4 sm:py-6 lg:py-8">
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Companies</h1>
        <Link
          href="/companies/create"
          class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md shadow-sm"
        >
          + New Company
        </Link>
      </div>

      <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 rounded-md shadow-sm">
          <thead class="bg-gray-100 dark:bg-gray-700">
            <tr>
              <th class="text-left p-3">Name</th>
              <th class="text-left p-3">Email</th>
              <th class="text-left p-3">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="company in companies"
              :key="company.id"
              class="hover:bg-gray-50 dark:hover:bg-gray-700 transition"
            >
              <td class="p-3">{{ company.name }}</td>
              <td class="p-3">{{ company.email ?? '-' }}</td>
              <td class="p-3">
                <Link
                  :href="route('companies.show', company.slug)"
                  class="text-blue-600 dark:text-blue-400 hover:underline"
                >
                  View
                </Link> |
                <Link
                  :href="route('companies.edit', company.slug)"
                  class="text-blue-600 dark:text-blue-400 hover:underline"
                >
                  Edit
                </Link>
                <span
                v-if="
                  ['Admin', 'Super Admin'].includes(authUser.role.name)
                "
              >
                |
                <Link
                  :href="route(company.archived ? 'companies.restore' : 'companies.destroy', company.slug)"
                  :method="company.archived ? 'post' : 'delete'"
                  as="button"
                  class="text-red-600 dark:text-red-400 hover:underline"
                >
                  {{ company.archived ? 'Restore' : 'Archive' }}
                </Link>
              </span>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </AppLayout>
</template>