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
    users: {
      type: Array,
      default: () => []
    },
  })
  
  // Coerce checkbox values to booleans explicitly
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
          <label for="dept_lead" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Department Lead</label>
          <select
            id="dept_lead"
            v-model="form.dept_lead"
            required
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
          >
            <option disabled value="">Select a user</option>
            <option
              v-for="user in users"
              :key="user.id"
              :value="user.id"
            >
              {{ user.name }}
            </option>
          </select>
        </div>
      </div>
  
      <div>
      <button
        type="submit"
        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700"
        :disabled="form.processing"
      >
        {{ isEdit ? 'Update Department' : 'Create Department' }}
      </button>
    </div>
    </form>
</template>