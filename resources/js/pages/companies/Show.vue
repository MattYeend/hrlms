<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import { type BreadcrumbItem } from '@/types'

const props = defineProps<{
  company: {
    id: number
    name: string
    slug: string
    first_line: string
    second_line: string | null
    town: string | null
    city: string | null
    county: string | null
    country: string | null
    postcode: string
    phone: string | null
    email: string | null
    is_active: boolean
    is_default: boolean
  }
}>()

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Dashboard', href: route('dashboard') },
  { title: 'Companies', href: route('companies.index') },
  { title: props.company.name, href: route('companies.show', props.company.id) },
]
</script>

<template>
  <AppLayout :title="props.company.name" :breadcrumbs="breadcrumbs">
    <Head :title="props.company.name" />

    <div class="px-4 sm:px-6 lg:px-8 py-4 sm:py-6 lg:py-8 space-y-4">
      <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ props.company.name }}</h1>
        <Link
          :href="route('companies.edit', props.company.id)"
          class="text-blue-600 hover:underline dark:text-blue-400"
        >
          Edit
        </Link>
      </div>

      <div class="bg-white dark:bg-gray-800 rounded-md shadow-sm p-6 space-y-2">
        <p><strong>Slug:</strong> {{ props.company.slug }}</p>
        <p>
          <strong>Address:</strong>
          {{ props.company.first_line }},
          {{ props.company.second_line ?? '' }}
          {{ props.company.town ?? '' }},
          {{ props.company.city ?? '' }},
          {{ props.company.county ?? '' }},
          {{ props.company.country ?? '' }},
          {{ props.company.postcode }}
        </p>
        <p><strong>Email:</strong> {{ props.company.email ?? '-' }}</p>
        <p><strong>Phone:</strong> {{ props.company.phone ?? '-' }}</p>
        <p><strong>Active:</strong> {{ props.company.is_active ? 'Yes' : 'No' }}</p>
        <p><strong>Default:</strong> {{ props.company.is_default ? 'Yes' : 'No' }}</p>
      </div>
    </div>
  </AppLayout>
</template>