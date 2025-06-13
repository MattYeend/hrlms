<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import { type BreadcrumbItem } from '@/types'
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'

const props = defineProps<{
    quiz: {
        id: number
        title: string
        slug: string
        description?: string
        pass_percentage: number
        learning_provider?: { id: number; name: string }
        is_archived: boolean
    }
    from: 'index' | 'archived'
}>()

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: route('dashboard') },
    { title: 'Quizzes', href: route('quizzes.index') },
    { title: 'Details', href: '#' },
]

const page = usePage()
const pageFrom = computed(() => page.props.from ?? 'index')
</script>

<template>
    <AppLayout title="Quiz Details" :breadcrumbs="breadcrumbs">
        <Head title="Quiz Details" />

        <div class="px-4 sm:px-6 lg:px-8 py-4 sm:py-6 lg:py-8 space-y-6">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Quiz Details</h1>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 space-y-2">
                <p><strong>Title:</strong> {{ quiz.title }}</p>
                <p><strong>Description:</strong> {{ quiz.description ?? '-' }}</p>
                <p><strong>Pass Percentage:</strong> {{ quiz.pass_percentage }}%</p>
                <p>
                    <strong>Learning Provider:</strong>
                    {{ quiz.learning_provider?.name ?? '-' }}
                </p>
                <p><strong>Status:</strong> {{ quiz.is_archived ? 'Archived' : 'Active' }}</p>
            </div>

            <div class="flex space-x-4">
                <Link
                    :href="route('quizzes.edit', quiz.slug)"
                    class="text-sm btn btn-primary"
                >
                    Edit
                </Link>
                <Link
                    :href="(props.from ?? pageFrom) === 'archived' ? route('quizzes.archived') : route('quizzes.index')"
                    class="text-sm text-muted-foreground"
                >
                    Back
                </Link>
            </div>
        </div>
    </AppLayout>
</template>
