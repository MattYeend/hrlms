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
	learningProvider?: any
	businessTypes: Array<{ id: number; name: string }>
}>()

const form = useForm({
	name: '',
	business_type_id: null as number | null,
	first_line: '',
	second_line: '',
	town: '',
	city: '',
	county: '',
	country: '',
	postcode: '',
	main_email_address: '',
	first_phone_number: '',
    second_phone_number: '',
	person_to_contact: '',
})

watchEffect(() => {
	if (props.isEdit && props.learningProvider) {
		Object.assign(form, {
			name: props.learningProvider.name ?? '',
			business_type_id: props.learningProvider.business_type_id ?? null,
            first_line: props.learningProvider.first_line ?? '',
			second_line: props.learningProvider.second_line ?? '',
			town: props.learningProvider.town ?? '',
			city: props.learningProvider.city ?? '',
			county: props.learningProvider.county ?? '',
			country: props.learningProvider.country ?? '',
			postcode: props.learningProvider.postcode ?? '',
            main_email_address: props.learningProvider.main_email_address ?? '',
            first_phone_number: props.learningProvider.first_phone_number ?? '',
            second_phone_number: props.learningProvider.second_phone_number ?? '',
            person_to_contact: props.learningProvider.person_to_contact ?? '',
		})
	}
})

const submit = () => {
	if (props.isEdit && props.learningProvider) {
		form.put(route('learningProviders.update', props.learningProvider.slug))
	} else {
		form.post(route('learningProviders.store'))
	}
}
</script>

<template>
	<form @submit.prevent="submit" class="space-y-6 max-w-2xl">
		<div class="grid gap-4">
			<!-- Name -->
			<div class="grid gap-2">
				<Label for="name">Name</Label>
				<Input id="name" v-model="form.name" type="text" required placeholder="Enter the Learning Provider company name" />
				<InputError :message="form.errors.name" />
			</div>

			<!-- Business Types -->
			<div class="grid gap-2">
				<Label for="business_type_id">Business Type</Label>
				<select v-model="form.business_type_id" id="business_type_id" class="input">
					<option :value="null" disabled>Select a department</option>
					<option v-for="businessType in businessTypes" :key="businessType.id" :value="businessType.id">
						{{ businessType.name }}
					</option>
				</select>
				<InputError :message="form.errors.business_type_id" />
			</div>

			<!-- Address fields -->
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
				<Label for="postcode">Post Code</Label>
				<Input id="postcode" v-model="form.postcode" type="text" required placeholder="Enter postcode" />
				<InputError :message="form.errors.postcode" />
			</div>

            <!-- Contact fields -->
            <div class="grid gap-2">
				<Label for="person_to_contact">Person to contact</Label>
				<Input id="person_to_contact" v-model="form.person_to_contact" type="text" required placeholder="Enter the person to contact" />
				<InputError :message="form.errors.person_to_contact" />
			</div>

            <div class="grid gap-2">
				<Label for="main_email_address">Main Email Address</Label>
				<Input id="main_email_address" v-model="form.main_email_address" type="email" required placeholder="Enter main email address" />
				<InputError :message="form.errors.main_email_address" />
			</div>

            <div class="grid gap-2">
				<Label for="first_phone_number">Main phone number</Label>
				<Input id="first_phone_number" v-model="form.first_phone_number" type="tel" required placeholder="Enter main phone number" />
				<InputError :message="form.errors.first_phone_number" />
			</div>

            <div class="grid gap-2">
				<Label for="second_phone_number">Secondary phone number</Label>
				<Input id="second_phone_number" v-model="form.second_phone_number" type="tel" placeholder="Enter secondary phone number if required" />
				<InputError :message="form.errors.second_phone_number" />
			</div>

			<!-- Submit Buttons -->
			<div class="flex gap-4">
				<button
					type="submit"
					class="text-sm btn btn-secondary cursor-pointer"
					:disabled="form.processing"
				>
					{{ isEdit ? 'Update Learning Provider' : 'Create Learning Provider' }}
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