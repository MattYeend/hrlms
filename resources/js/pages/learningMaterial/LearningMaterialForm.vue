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
    learningMaterial?: any
	learningProvider: Array<{ id: number; name: string }>
	department: Array<{ id: number; name: string }>
}>()

const form = useForm({
	title: '',
    key_objectives: '',
    description: '',
    file: null as File | null,	
    learning_provider_id: null as number | null,
    department_id: null as number | null,
})

watchEffect(() => {
	if (props.isEdit && props.learningMaterial) {
		form.title = props.learningMaterial.title ?? ''
		form.key_objectives = props.learningMaterial.key_objectives ?? ''
		form.description = props.learningMaterial.description ?? ''
		form.file = null
		form.learning_provider_id = props.learningMaterial.learning_provider_id ?? null
		form.department_id = props.learningMaterial.department_id ?? null
	}
})

const submit = () => {
	if (props.isEdit && props.learningMaterial) {
		form.put(route('learningMaterials.update', props.learningMaterial.slug))
	} else {
		form.post(route('learningMaterials.store'))
	}
}
</script>

<template>
	<form @submit.prevent="submit" class="space-y-6 max-w-2xl">
		<div class="grid gap-4">
			<!-- Title -->
			<div class="grid gap-2">
				<Label for="title">Title</Label>
				<Input id="title" v-model="form.title" type="text" required placeholder="Enter the Learning Material title" />
				<InputError :message="form.errors.title" />
			</div>

			<!-- Key Ojectives -->
			<div class="grid gap-2">
				<Label for="key_objectives">Key Ojectives</Label>
				<Input id="key_objectives" v-model="form.key_objectives" type="text" required placeholder="Enter the key objectives" />
				<InputError :message="form.errors.key_objectives" />
			</div>

            <!-- Description -->
            <div class="grid gap-2">
				<Label for="description">Description</Label>
				<Input id="description" v-model="form.description" type="text" required placeholder="Enter the description" />
				<InputError :message="form.errors.description" />
			</div>

            <div class="grid gap-2">
                <Label for="file">Upload File</Label>

                <!-- Show link to existing file if editing -->
                <div v-if="props.isEdit && props.learningMaterial?.file_path" class="text-sm text-muted-foreground">
                    Current File:
                    <a
                        :href="`/storage/${props.learningMaterial.file_path}`"
                        class="text-blue-600 underline"
                        target="_blank"
                    >
                        Download
                    </a>
                </div>

                <Input
                    id="file"
                    type="file"
                    @change="(e: Event) => form.file = (e.target as HTMLInputElement).files?.[0] ?? null"
                />
                <InputError :message="form.errors.file" />
            </div>

			<!-- Learning Provider -->
			<div class="grid gap-2">
				<Label for="learning_provider_id">Learning Provider</Label>
				<select v-model="form.learning_provider_id" id="learning_provider_id" class="input">
					<option :value="null" disabled>Select a learning provider</option>
					<option v-for="learningProvider in learningProvider" :key="learningProvider.id" :value="learningProvider.id">
						{{ learningProvider.name }}
					</option>
				</select>
				<InputError :message="form.errors.learning_provider_id" />
			</div>

            <!-- Department -->
			<div class="grid gap-2">
				<Label for="department_id">Department</Label>
				<select v-model="form.department_id" id="department_id" class="input">
					<option :value="null" disabled>Select a department</option>
					<option v-for="department in department" :key="department.id" :value="department.id">
						{{ department.name }}
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
					{{ isEdit ? 'Update Learning Material' : 'Create Learning Material' }}
				</button>
				<Link 
					:href="route('learningProviders.index')"
					class="text-sm text-muted-foreground"
				>
					Back
				</Link>
			</div>
		</div>
	</form>
</template>