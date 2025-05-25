<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import CompanyForm from '../companies/CompanyForm.vue'
import { type BreadcrumbItem } from '@/types'

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Dashboard', href: route('dashboard') },
  { title: 'Companies', href: route('companies.index') },
  { title: 'Create', href: route('companies.create') },
]
</script>

<template>
  <AppLayout title="Create Company" :breadcrumbs="breadcrumbs">
    <Head title="Create Company" />

    <div class="px-4 sm:px-6 lg:px-8 py-4 sm:py-6 lg:py-8">
      <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">Create Company</h1>
      <CompanyForm :is-edit="false" />
    </div>
  </AppLayout>
</template>