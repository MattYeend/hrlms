<template>
    <form @submit.prevent="submit">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label for="name">Name</label>
          <input id="name" v-model="form.name" type="text" required />
        </div>
        <div>
          <label for="slug">Slug</label>
          <input id="slug" v-model="form.slug" type="text" required />
        </div>
        <div>
          <label for="first_line">First Line</label>
          <input id="first_line" v-model="form.first_line" type="text" required />
        </div>
        <div>
          <label for="second_line">Second Line</label>
          <input id="second_line" v-model="form.second_line" type="text" />
        </div>
        <div>
          <label for="town">Town</label>
          <input id="town" v-model="form.town" type="text" />
        </div>
        <div>
          <label for="city">City</label>
          <input id="city" v-model="form.city" type="text" />
        </div>
        <div>
          <label for="county">County</label>
          <input id="county" v-model="form.county" type="text" />
        </div>
        <div>
          <label for="country">Country</label>
          <input id="country" v-model="form.country" type="text" />
        </div>
        <div>
          <label for="postcode">Postcode</label>
          <input id="postcode" v-model="form.postcode" type="text" required />
        </div>
        <div>
          <label for="phone">Phone</label>
          <input id="phone" v-model="form.phone" type="text" />
        </div>
        <div>
          <label for="email">Email</label>
          <input id="email" v-model="form.email" type="email" />
        </div>
        <div>
          <label>
            <input type="checkbox" v-model="form.is_default" />
            Default
          </label>
        </div>
      </div>
      <div class="mt-4">
        <button type="submit" class="btn btn-primary">
          {{ isEdit ? 'Update' : 'Create' }}
        </button>
      </div>
    </form>
  </template>
  
  <script setup lang="ts">
  import { reactive } from 'vue'
  import { useForm } from '@inertiajs/vue3'
  
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