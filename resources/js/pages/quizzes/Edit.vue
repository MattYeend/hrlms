<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import QuizForm from '../quizzes/QuizForm.vue'
import { type BreadcrumbItem } from '@/types'

import { PropType } from 'vue'

defineProps({
    quiz: {
        type: Object as PropType<{
            id: number
            title: string
            slug: string
            pass_percentage: number
            description?: string
            learning_provider?: { id: number; name: string }
            is_archived: boolean
        }>,
        required: true,
    },
    learningProviders: {
        type: Array as PropType<Array<{ id: number; name: string }>>,
        required: true,
    },
    users: {
        type: Array as PropType<Array<{ id: number; name: string }>>,
        required: false,
    },
})

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: route('dashboard') },
    { title: 'Quizzes', href: route('quizzes.index') },
    { title: 'Edit', href: '#' },
]
</script>

<template>
    <AppLayout title="Edit Quiz" :breadcrumbs="breadcrumbs">
        <Head title="Edit Quiz" />
        <div class="px-4 sm:px-6 lg:px-8 py-4 sm:py-6 lg:py-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">Edit Quiz</h1>
            <QuizForm
                :is-edit="true"
                :quiz="quiz"
                :learningProviders="learningProviders"
                :users="users" 
            />
        </div>
    </AppLayout>
</template>
