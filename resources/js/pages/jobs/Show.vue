<script setup lang="ts">
import { 
	Head, 
	Link 
} from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import { type BreadcrumbItem } from '@/types'
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'

const props = defineProps<{
	job: {
		id: number
		title: string
		short_code: string
        description: string | null
		department: { name: string } | null
		slug: string
	}, 
	from: 'index' | 'archived'
}>()

const breadcrumbs: BreadcrumbItem[] = [
	{ title: 'Dashboard', href: route('dashboard') },
	{ title: 'Jobs', href: route('jobs.index') },
	{ title: 'Details', href: '#' },
]

const page = usePage()
const pageFrom = computed(() => page.props.from ?? 'index')

</script>

<template>
	<AppLayout title="User Details" :breadcrumbs="breadcrumbs">
		<Head title="User Details" />

		<div class="px-4 sm:px-6 lg:px-8 py-4 sm:py-6 lg:py-8 space-y-6">
			<h1 class="text-3xl font-bold text-gray-900 dark:text-white">User Details</h1>

			<div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 space-y-2">
				<p><strong>Title:</strong> {{ job.title }}</p>
				<p><strong>Short Code:</strong> {{ job.short_code }}</p>
				<p><strong>Description:</strong> {{ job?.description ?? '—' }}</p>
				<p><strong>Department:</strong> {{ job.department?.name ?? '—' }}</p>
			</div>

			<div class="flex space-x-4">
				<Link :href="route('jobs.edit', job.slug)" class="btn btn-primary">Edit</Link>
				<Link :href="(props.from ?? pageFrom) === 'archived' ? route('jobs.archived') : route('jobs.index')" class="btn btn-secondary">Back</Link>
			</div>
		</div>
	</AppLayout>
</template>