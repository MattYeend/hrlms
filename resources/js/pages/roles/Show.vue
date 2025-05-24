<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import { type BreadcrumbItem } from '@/types'

const props = defineProps<{
    role: {
        id: number
        name: string
        slug: string
        description: string
        is_active: boolean
        is_default: boolean
    }
}>()

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: route('dashboard') },
    { title: 'Roles', href: route('roles.index') },
    { title: props.role.name, href: route('roles.show', props.role.id) },
]
</script>

<template>
    <AppLayout :title="`Role: ${props.role.name}`" :breadcrumbs="breadcrumbs">
        <Head :title="`Role: ${props.role.name}`" />

        <div class="px-4 sm:px-6 lg:px-8 py-4 sm:py-6 lg:py-8 space-y-4">
            <h1 class="text-3xl font-bold">{{ props.role.name }}</h1>
            <p><strong>Description:</strong> {{ props.role.description }}</p>
            <p><strong>Slug:</strong> {{ props.role.slug }}</p>
            <p><strong>Active:</strong> {{ props.role.is_active ? 'Yes' : 'No' }}</p>
            <p><strong>Default:</strong> {{ props.role.is_default ? 'Yes' : 'No' }}</p>
        </div>
    </AppLayout>
</template>