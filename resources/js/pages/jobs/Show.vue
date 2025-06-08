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
	userJob: {
		id: number
		job_title: string
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
	<AppLayout title="Job Details" :breadcrumbs="breadcrumbs">
		<Head title="Job Details" />

		<div class="px-4 sm:px-6 lg:px-8 py-4 sm:py-6 lg:py-8 space-y-6">
			<h1 class="text-3xl font-bold text-gray-900 dark:text-white">Job Details</h1>

			<div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 space-y-2">
				<p><strong>Title:</strong> {{ userJob.job_title }}</p>
				<p><strong>Short Code:</strong> {{ userJob.short_code }}</p>
				<p><strong>Description:</strong> {{ userJob?.description ?? '—' }}</p>
				<p><strong>Department:</strong> {{ userJob.department?.name ?? '—' }}</p>
			</div>

			<div class="flex space-x-4">
				<!-- <Link 
				 	:href="route('jobs.edit', userJob.slug)" 
					class="text-sm btn btn-primary"
				>
					Edit
				</Link> -->
				<Link 
					:href="(props.from ?? pageFrom) === 'archived' ? route('jobs.archived') : route('jobs.index')" 
					class="text-sm text-muted-foreground"
				>
					Back
				</Link>
			</div>
		</div>
	</AppLayout>
</template>