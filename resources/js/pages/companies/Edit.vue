<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import CompanyForm from '../companies/CompanyForm.vue'
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
    is_default: boolean
  }
}>()

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Dashboard', href: route('dashboard') },
  { title: 'Companies', href: route('companies.index') },
  { title: props.company.name, href: route('companies.show', props.company.slug) },
  { title: 'Edit', href: route('companies.edit', props.company.slug) },
]
</script>

<template>
  <AppLayout title="Edit Company" :breadcrumbs="breadcrumbs">
    <Head title="Edit Company" />

    <div class="px-4 sm:px-6 lg:px-8 py-4 sm:py-6 lg:py-8">
      <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">Edit Company</h1>
      <CompanyForm :company="props.company" :is-edit="true" />
    </div>
  </AppLayout>
</template>