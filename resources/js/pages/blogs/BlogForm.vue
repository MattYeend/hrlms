<script setup lang="ts">
import { watchEffect } from 'vue'
import { useForm, Link } from '@inertiajs/vue3'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Button } from '@/components/ui/button'
import { Checkbox } from '@/components/ui/checkbox'
import InputError from '@/components/InputError.vue'

const props = defineProps<{
	isEdit: boolean
	blog?: any
}>()

const form = useForm({
	title: '',
    content: '',
})

watchEffect(() => {
	if (props.isEdit && props.blog) {
		Object.assign(form, {
			title: props.blog.title ?? '',
			content: props.blog.content ?? '',
		})
	}
})

const submit = () => {
	if (props.isEdit && props.blog) {
		form.put(route('blogs.update', props.blog.slug))
	} else {
		form.post(route('blogs.store'))
	}
}
</script>

<template>
	<form @submit.prevent="submit" class="space-y-6 max-w-2xl">
		<div class="grid gap-4">
			<!-- Title -->
            <div class="grid gap-2">
				<Label for="title">Title</Label>
				<Input id="title" v-model="form.title" type="text" required placeholder="Enter the blog title" />
				<InputError :message="form.errors.title" />
			</div>

			<div class="grid gap-2">
				<Label for="content">Content</Label>
				<textarea
					id="content"
					v-model="form.content"
					required
					rows="6"
					placeholder="Enter the blog content"
					class="border border-gray-300 dark:border-gray-700 rounded-md shadow-sm p-2 w-full focus:ring focus:ring-blue-200 dark:bg-gray-900 dark:text-white resize-y"
				></textarea>
				<InputError :message="form.errors.content" />
			</div>

			<!-- Submit Buttons -->
			<div class="flex gap-4">
				<button 
					type="submit" 
					class="text-sm btn btn-secondary cursor-pointer"
					:disabled="form.processing"
				>
					{{ isEdit ? 'Update Blog' : 'Create Blog' }}
				</button>
				<Link 
					:href="route('blogs.index')"
					class="text-sm text-muted-foreground"
				>
					Back
				</Link>
			</div>
		</div>
	</form>
</template>