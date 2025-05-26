<template>
    <form @submit.prevent="submit">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label for="name" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Department Name</label>
          <input
            id="name"
            v-model="form.name"
            type="text"
            required
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
          />
        </div>
  
        <div class="md:col-span-2">
          <label for="description" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Description</label>
          <textarea
            id="description"
            v-model="form.description"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
            rows="3"
          ></textarea>
        </div>
  
        <div>
          <label class="inline-flex items-center mt-6">
            <input
              type="checkbox"
              v-model="form.is_default"
              class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring focus:ring-blue-300"
            />
            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Default</span>
          </label>
        </div>
      </div>
  
      <div class="mt-6">
        <button type="submit" class="btn btn-primary">
          {{ isEdit ? 'Update' : 'Create' }}
        </button>
      </div>
    </form>
  </template>
  
  <script setup lang="ts">
  import { useForm } from '@inertiajs/vue3'
  
  const props = defineProps({
    department: {
      type: Object,
      default: () => ({
        name: '',
        description: '',
        is_default: false,
      }),
    },
    isEdit: {
      type: Boolean,
      default: false,
    },
  })
  
  // Coerce checkbox values to booleans explicitly
  const form = useForm({
    name: props.department.name || '',
    description: props.department.description || '',
    is_default: Boolean(props.department.is_default),
  })
  
  const submit = () => {
    if (props.isEdit) {
      form.put(route('departments.update', props.department.id))
    } else {
      form.post(route('departments.store'))
    }
  }
  </script>