<script setup lang="ts">
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Button } from '@/components/ui/button'
import InputError from '@/components/InputError.vue'
import { useForm, Link } from '@inertiajs/vue3'

const props = defineProps({
	department: {
		type: Object,
		default: () => ({
			name: '',
			description: '',
			is_default: false,
			dept_lead: '',
		}),
	},
	isEdit: {
		type: Boolean,
		default: false,
	},
	users: {
		type: Array,
		default: () => [],
	},
})

const form = useForm({
	name: props.department.name || '',
	description: props.department.description || '',
	is_default: Boolean(props.department.is_default),
	dept_lead: props.department.dept_lead || '',
})

const submit = () => {
	if (props.isEdit) {
		form.put(route('departments.update', props.department.slug))
	} else {
		form.post(route('departments.store'))
	}
}
</script>

<template>
	<form @submit.prevent="submit" class="space-y-6 max-w-2xl">
		<div class="grid gap-4">
			<!-- Department Name -->
			<div class="grid gap-2">
				<Label for="name">Department Name</Label>
				<Input
					id="name"
					v-model="form.name"
					type="text"
					required
					placeholder="Enter department name"
				/>
				<InputError :message="form.errors.name" />
			</div>

			<!-- Description -->
			<div class="grid gap-2">
				<Label for="description">Description</Label>
				<textarea
					id="description"
					v-model="form.description"
					class="block w-full rounded-md border border-input bg-background px-3 py-2 text-sm shadow-sm placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2"
					rows="3"
					placeholder="Enter a description"
				/>
				<InputError :message="form.errors.description" />
			</div>

			<!-- Department Lead -->
			<div class="grid gap-2">
				<Label for="dept_lead">Department Lead</Label>
				<select id="dept_lead" v-model="form.dept_lead" required class="input">
					<option disabled value="">Select a user</option>
					<option v-for="user in users" :key="user.id" :value="user.id">
						{{ user.name }}
					</option>
				</select>
				<InputError :message="form.errors.dept_lead" />
			</div>

			<!-- Submit Buttons -->
			<div class="flex gap-4">
				<Button type="submit" :disabled="form.processing">
					{{ isEdit ? 'Update Department' : 'Create Department' }}
				</Button>
				<Link :href="route('departments.index')" class="text-sm underline text-muted-foreground">Back</Link>
			</div>
		</div>
	</form>
</template>