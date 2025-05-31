<script setup lang="ts">
import { useForm, Link } from '@inertiajs/vue3'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Button } from '@/components/ui/button'
import InputError from '@/components/InputError.vue'

const props = defineProps({
  company: {
    type: Object,
    default: () => ({
      name: '',
      slug: '',
      first_line: '',
      second_line: '',
      town: '',
      city: '',
      county: '',
      country: '',
      postcode: '',
      phone: '',
      email: '',
      is_default: false,
    }),
  },
  isEdit: {
    type: Boolean,
    default: false,
  },
})

const form = useForm({ ...props.company })

const submit = () => {
  if (props.isEdit) {
    form.put(route('companies.update', props.company.slug))
  } else {
    form.post(route('companies.store'))
  }
}
</script>

<template>
  <form @submit.prevent="submit" class="space-y-6 max-w-4xl">
    <div class="grid gap-4 md:grid-cols-2">

      <div class="grid gap-2">
        <Label for="name">Name</Label>
        <Input id="name" v-model="form.name" type="text" required placeholder="Enter company name" />
        <InputError :message="form.errors.name" />
      </div>

      <div class="grid gap-2">
        <Label for="first_line">First Line</Label>
        <Input id="first_line" v-model="form.first_line" type="text" required placeholder="Enter first line of address" />
        <InputError :message="form.errors.first_line" />
      </div>

      <div class="grid gap-2">
        <Label for="second_line">Second Line</Label>
        <Input id="second_line" v-model="form.second_line" type="text" placeholder="Enter second line of address if applicable" />
        <InputError :message="form.errors.second_line" />
      </div>

      <div class="grid gap-2">
        <Label for="town">Town</Label>
        <Input id="town" v-model="form.town" type="text" placeholder="Enter town if applicable" />
        <InputError :message="form.errors.town" />
      </div>

      <div class="grid gap-2">
        <Label for="city">City</Label>
        <Input id="city" v-model="form.city" type="text" placeholder="Enter city if applicable" />
        <InputError :message="form.errors.city" />
      </div>

      <div class="grid gap-2">
        <Label for="county">County</Label>
        <Input id="county" v-model="form.county" type="text" placeholder="Enter county if applicable" />
        <InputError :message="form.errors.county" />
      </div>

      <div class="grid gap-2">
        <Label for="country">Country</Label>
        <Input id="country" v-model="form.country" type="text" placeholder="Enter country if applicable" />
        <InputError :message="form.errors.country" />
      </div>

      <div class="grid gap-2">
        <Label for="postcode">Postcode</Label>
        <Input id="postcode" v-model="form.postcode" type="text" required placeholder="Enter postcode" />
        <InputError :message="form.errors.postcode" />
      </div>

      <div class="grid gap-2">
        <Label for="phone">Phone</Label>
        <Input id="phone" v-model="form.phone" type="text" placeholder="Enter phone number of company" />
        <InputError :message="form.errors.phone" />
      </div>

      <div class="grid gap-2">
        <Label for="email">Email</Label>
        <Input id="email" v-model="form.email" type="email" placeholder="Enter company email address" />
        <InputError :message="form.errors.email" />
      </div>
    </div>

    <div class="flex gap-4">
      <Button type="submit" :disabled="form.processing">
        {{ isEdit ? 'Update Company' : 'Create Company' }}
      </Button>
      <Link :href="route('companies.index')" class="text-sm underline text-muted-foreground">
        Back
      </Link>
    </div>
  </form>
</template>