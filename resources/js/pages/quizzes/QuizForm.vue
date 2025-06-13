<script setup lang="ts">
import { watchEffect } from 'vue'
import { useForm, Link } from '@inertiajs/vue3'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Button } from '@/components/ui/button'
import InputError from '@/components/InputError.vue'

const props = defineProps<{
    isEdit: boolean
    quiz?: {
        id: number
        title: string
        slug: string
        description?: string
        pass_percentage: number
        learning_provider?: { id: number; name: string }
        is_archived: boolean
    }
    learningProviders: Array<{ id: number; name: string }>
}>()

const form = useForm({
    title: '',
    slug: '',
    description: '',
    pass_percentage: 0,
    learning_provider_id: null as number | null,
    is_archived: false,
})

watchEffect(() => {
    if (props.isEdit && props.quiz) {
        Object.assign(form, {
            title: props.quiz.title ?? '',
            slug: props.quiz.slug ?? '',
            description: props.quiz.description ?? '',
            pass_percentage: props.quiz.pass_percentage ?? 0,
            learning_provider_id: props.quiz.learning_provider?.id ?? null,
            is_archived: props.quiz.is_archived ?? false,
        })
    }
})

const submit = () => {
    if (props.isEdit && props.quiz) {
        form.put(route('quizzes.update', props.quiz.slug))
    } else {
        form.post(route('quizzes.store'))
    }
}
</script>

<template>
    <form @submit.prevent="submit" class="space-y-6 max-w-2xl">
        <!-- Title -->
        <div class="grid gap-2">
            <Label for="title">Title</Label>
            <Input
                id="title"
                v-model="form.title"
                type="text"
                required
                placeholder="Enter the quiz title"
            />
            <InputError :message="form.errors.title" />
        </div>

        <!-- Description -->
        <div class="grid gap-2">
            <Label for="description">Description</Label>
            <textarea
                id="description"
                v-model="form.description"
                rows="4"
                placeholder="Enter quiz description (optional)"
                class="input resize-none"
            />
            <InputError :message="form.errors.description" />
        </div>

        <!-- Pass Percentage -->
        <div class="grid gap-2">
            <Label for="pass_percentage">Pass Percentage</Label>
            <Input
                id="pass_percentage"
                v-model.number="form.pass_percentage"
                type="number"
                min="0"
                max="100"
                step="0.01"
                required
                placeholder="Enter pass percentage"
            />
            <InputError :message="form.errors.pass_percentage" />
        </div>

        <!-- Learning Provider -->
        <div class="grid gap-2">
            <Label for="learning_provider_id">Learning Provider</Label>
            <select
                id="learning_provider_id"
                v-model="form.learning_provider_id"
                class="input"
            >
                <option :value="null" disabled>Select a learning provider</option>
                <option
                    v-for="provider in learningProviders"
                    :key="provider.id"
                    :value="provider.id"
                >
                    {{ provider.name }}
                </option>
            </select>
            <InputError :message="form.errors.learning_provider_id" />
        </div>

        <!-- Submit buttons -->
        <div class="flex gap-4">
            <Button type="submit" :disabled="form.processing">
                {{ isEdit ? 'Update Quiz' : 'Create Quiz' }}
            </Button>
            <Link 
                :href="route('quizzes.index')"
                class="text-sm text-muted-foreground"
            >
                Back
            </Link>
        </div>
    </form>
</template>
