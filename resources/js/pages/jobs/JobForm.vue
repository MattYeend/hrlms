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
	job?: any
	departments: Array<{ id: number; name: string }>
}>()

const form = useForm({
	job_title: '',
	short_code: '',
	description: '',
	department_id: null as number | null,
})

watchEffect(() => {
	if (props.isEdit && props.job) {
		Object.assign(form, {
			job_title: props.job.job_title ?? '',
			short_code: props.job.short_code ?? '',
			description: props.job.description ?? '',
			department_id: props.job.department_id ?? null,
		})
	}
})

const submit = () => {
	if (props.isEdit && props.job) {
		form.put(route('jobs.update', props.job.slug))
	} else {
		form.post(route('jobs.store'))
	}
}
</script>

<template>
	<form @submit.prevent="submit" class="space-y-6 max-w-2xl">
		<div class="grid gap-4">
			<!-- Title -->
			<div class="grid gap-2">
				<Label for="title">Title</Label>
				<Input id="title" v-model="form.job_title" type="text" required placeholder="Enter the job title" />
				<InputError :message="form.errors.job_title" />
			</div>

			<!-- Short code -->
			<div class="grid gap-2">
				<Label for="short_code">Short Code</Label>
				<Input id="short_code" v-model="form.short_code" type="text" required placeholder="Enter the short code" />
				<InputError :message="form.errors.short_code" />
			</div>

			<!-- Description -->
			<div class="grid gap-2">
				<Label for="description">Description</Label>
				<Input id="description" v-model="form.description" type="text" placeholder="Enter a valid description address" />
				<InputError :message="form.errors.description" />
			</div>

			<!-- Department -->
			<div class="grid gap-2">
				<Label for="department_id">Department</Label>
				<select v-model="form.department_id" id="department_id" class="input">
					<option :value="null" disabled>Select a department</option>
					<option v-for="dept in departments" :key="dept.id" :value="dept.id">
						{{ dept.name }}
					</option>
				</select>
				<InputError :message="form.errors.department_id" />
			</div>

			<!-- Submit Buttons -->
			<div class="flex gap-4">
				<button
					type="submit"
					class="text-sm btn btn-secondary cursor-pointer"
					:disabled="form.processing"
				>
					{{ isEdit ? 'Update Job' : 'Create Job' }}
				</button>
				<Link 
					:href="route('jobs.index')"
					class="text-sm text-muted-foreground"
				>
					Back
				</Link>
			</div>
		</div>
	</form>
</template>