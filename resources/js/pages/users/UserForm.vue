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
	user?: any
	roles: Array<{ id: number; name: string }>
	departments: Array<{ id: number; name: string }>
	jobs: Array<{ id: number; job_title: string }>
}>()

const form = useForm({
	title: '',
	name: '',
	email: '',
	password: '',
	password_confirmation: '',
	first_line: '',
	second_line: '',
	town: '',
	city: '',
	county: '',
	country: '',
	post_code: '',
	full_time: false,
	part_time: false,
	role_id: null as number | null,
	department_id: null as number | null,
	job_id: null as number | null,
})

watchEffect(() => {
	if (props.isEdit && props.user) {
		Object.assign(form, {
			title: props.user.title ?? '',
			name: props.user.name ?? '',
			email: props.user.email ?? '',
			first_line: props.user.first_line ?? '',
			second_line: props.user.second_line ?? '',
			town: props.user.town ?? '',
			city: props.user.city ?? '',
			county: props.user.county ?? '',
			country: props.user.country ?? '',
			post_code: props.user.post_code ?? '',
			full_time: Boolean(props.user.full_time),
			part_time: Boolean(props.user.part_time),
			role_id: props.user.role_id ?? null,
			department_id: props.user.department_id ?? null,
			job_id: props.user.job_id ?? null,
		})
	}
})

const submit = () => {
	if (props.isEdit && props.user) {
		form.put(route('users.update', props.user.id))
	} else {
		form.post(route('users.store'))
	}
}
</script>

<template>
	<form @submit.prevent="submit" class="space-y-6 max-w-2xl">
		<div class="grid gap-4">
			<!-- Title -->
			<div class="grid gap-2">
				<Label for="title">Title</Label>
				<select v-model="form.title" id="title" class="input">
					<option value="" disabled>Select a title</option>
					<option value="Mr">Mr</option>
					<option value="Mrs">Mrs</option>
					<option value="Miss">Miss</option>
					<option value="Ms">Ms</option>
					<option value="Dr">Dr</option>
					<option value="Prof">Prof</option>
				</select>
				<InputError :message="form.errors.title" />
			</div>

			<!-- Name -->
			<div class="grid gap-2">
				<Label for="name">Name</Label>
				<Input id="name" v-model="form.name" type="text" required placeholder="Enter the persons name" />
				<InputError :message="form.errors.name" />
			</div>

			<!-- Email -->
			<div class="grid gap-2">
				<Label for="email">Email</Label>
				<Input id="email" v-model="form.email" type="email" required placeholder="Enter a valid email address" />
				<InputError :message="form.errors.email" />
			</div>

			<!-- Password -->
			<div v-if="!isEdit" class="grid gap-2">
				<Label for="password">Password</Label>
				<Input id="password" v-model="form.password" type="password" required placeholder="Enter a secure and unique password" />
				<InputError :message="form.errors.password" />
			</div>

			<!-- Password Confirmation -->
			<div v-if="!isEdit" class="grid gap-2">
				<Label for="password_confirmation">Confirm Password</Label>
				<Input id="password_confirmation" v-model="form.password_confirmation" type="password" required placeholder="Re-enter the secure and unique password" />
			</div>

			<!-- Address Fields -->
			<div class="grid gap-2">
				<Label for="first_line">Address Line 1</Label>
				<Input id="first_line" v-model="form.first_line" type="text" required placeholder="Enter first line of address" />
				<InputError :message="form.errors.first_line" />
			</div>

			<div class="grid gap-2">
				<Label for="second_line">Address Line 2</Label>
				<Input id="second_line" v-model="form.second_line" type="text" placeholder="Enter second line of address if applicable" />
			</div>

			<div class="grid gap-2">
				<Label for="town">Town</Label>
				<Input id="town" v-model="form.town" type="text" placeholder="Enter town if applicable" />
			</div>

			<div class="grid gap-2">
				<Label for="city">City</Label>
				<Input id="city" v-model="form.city" type="text" placeholder="Enter city if applicable" />
			</div>

			<div class="grid gap-2">
				<Label for="county">County</Label>
				<Input id="county" v-model="form.county" type="text" placeholder="Enter county if applicable" />
			</div>

			<div class="grid gap-2">
				<Label for="country">Country</Label>
				<Input id="country" v-model="form.country" type="text" placeholder="Enter country if applicable" />
			</div>

			<div class="grid gap-2">
				<Label for="post_code">Post Code</Label>
				<Input id="post_code" v-model="form.post_code" type="text" required placeholder="Enter postcode" />
				<InputError :message="form.errors.post_code" />
			</div>

			<!-- Full Time / Part Time -->
			<div class="flex gap-6">
				<Label class="inline-flex items-center gap-2">
				<Checkbox v-model="form.full_time" id="full_time" />
				Full Time
				</Label>
				<Label class="inline-flex items-center gap-2">
				<Checkbox v-model="form.part_time" id="part_time" />
				Part Time
				</Label>
			</div>
			<InputError :message="form.errors.full_time" />
			<InputError :message="form.errors.part_time" />

			<!-- Role -->
			<div class="grid gap-2">
				<Label for="role_id">Role</Label>
				<select v-model="form.role_id" id="role_id" class="input">
					<option :value="null" disabled>Select a role</option>
					<option v-for="role in roles" :key="role.id" :value="role.id">
						{{ role.name }}
					</option>
				</select>
				<InputError :message="form.errors.role_id" />
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

			<!-- Job -->
			 <div class="grid gap-2">
				<Label for="job_id">Job</Label>
				<select v-model="form.job_id" id="job_id" class="input">
					<option :value="null" disabled>Select a job</option>
					<option v-for="job in jobs" :key="job.id" :value="job.id">
						{{ job.job_title }}
					</option>
				</select>
				<InputError :message="form.errors.job_id" />
			</div>

			<!-- Submit Buttons -->
			<div class="flex gap-4">
				<Button type="submit" :disabled="form.processing">
					{{ isEdit ? 'Update User' : 'Create User' }}
				</Button>
				<Link :href="route('users.index')" class="text-sm underline text-muted-foreground">
					Back
				</Link>
			</div>
		</div>
	</form>
</template>