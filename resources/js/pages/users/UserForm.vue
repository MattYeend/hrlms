<script setup lang="ts">
import { watchEffect } from 'vue'
import { useForm, Link } from '@inertiajs/vue3'

const props = defineProps<{
  isEdit: boolean
  user?: any
  roles: Array<{ id: number; name: string }>
  departments: Array<{ id: number; name: string }>
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
  <form @submit.prevent="submit" class="space-y-6">

    <!-- Title -->
    <div>
      <label for="title">Title</label>
      <input v-model="form.title" id="title" type="text" class="input" />
      <div v-if="form.errors.title" class="error">{{ form.errors.title }}</div>
    </div>

    <!-- Name -->
    <div>
      <label for="name">Name</label>
      <input v-model="form.name" id="name" type="text" class="input" />
      <div v-if="form.errors.name" class="error">{{ form.errors.name }}</div>
    </div>

    <!-- Email -->
    <div>
      <label for="email">Email</label>
      <input v-model="form.email" id="email" type="email" class="input" />
      <div v-if="form.errors.email" class="error">{{ form.errors.email }}</div>
    </div>

    <!-- Password (only if creating) -->
    <div v-if="!isEdit">
      <label for="password">Password</label>
      <input v-model="form.password" id="password" type="password" class="input" />
      <div v-if="form.errors.password" class="error">{{ form.errors.password }}</div>
    </div>

    <div v-if="!isEdit">
      <label for="password_confirmation">Confirm Password</label>
      <input v-model="form.password_confirmation" id="password_confirmation" type="password" class="input" />
    </div>

    <!-- Address Fields -->
    <div>
      <label for="first_line">Address Line 1</label>
      <input v-model="form.first_line" id="first_line" type="text" class="input" />
      <div v-if="form.errors.first_line" class="error">{{ form.errors.first_line }}</div>
    </div>

    <div>
      <label for="second_line">Address Line 2</label>
      <input v-model="form.second_line" id="second_line" type="text" class="input" />
    </div>

    <div>
      <label for="town">Town</label>
      <input v-model="form.town" id="town" type="text" class="input" />
    </div>

    <div>
      <label for="city">City</label>
      <input v-model="form.city" id="city" type="text" class="input" />
    </div>

    <div>
      <label for="county">County</label>
      <input v-model="form.county" id="county" type="text" class="input" />
    </div>

    <div>
      <label for="country">Country</label>
      <input v-model="form.country" id="country" type="text" class="input" />
    </div>

    <div>
      <label for="post_code">Post Code</label>
      <input v-model="form.post_code" id="post_code" type="text" class="input" />
      <div v-if="form.errors.post_code" class="error">{{ form.errors.post_code }}</div>
    </div>

    <!-- Full Time & Part Time -->
    <div class="flex items-center space-x-4">
      <label class="inline-flex items-center">
        <input v-model="form.full_time" type="checkbox" class="form-checkbox" />
        <span class="ml-2">Full Time</span>
      </label>
      <label class="inline-flex items-center">
        <input v-model="form.part_time" type="checkbox" class="form-checkbox" />
        <span class="ml-2">Part Time</span>
      </label>
    </div>
    <div v-if="form.errors.full_time" class="error">{{ form.errors.full_time }}</div>
    <div v-if="form.errors.part_time" class="error">{{ form.errors.part_time }}</div>

    <!-- Role -->
    <div>
      <label for="role_id">Role</label>
      <select v-model="form.role_id" id="role_id" class="input">
        <option :value="null">Select a role</option>
        <option v-for="role in roles" :key="role.id" :value="role.id">
          {{ role.name }}
        </option>
      </select>
      <div v-if="form.errors.role_id" class="error">{{ form.errors.role_id }}</div>
    </div>

    <!-- Department -->
    <div>
      <label for="department_id">Department</label>
      <select v-model="form.department_id" id="department_id" class="input">
        <option :value="null">Select a department</option>
        <option v-for="dept in departments" :key="dept.id" :value="dept.id">
          {{ dept.name }}
        </option>
      </select>
      <div v-if="form.errors.department_id" class="error">{{ form.errors.department_id }}</div>
    </div>

    <!-- Submit -->
    <div>
      <button
        type="submit"
        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700"
        :disabled="form.processing"
      >
        {{ isEdit ? 'Update User' : 'Create User' }}
      </button>
      <Link :href="route('departments.index')" class="btn btn-secondary">Back</Link>
    </div>
  </form>
</template>