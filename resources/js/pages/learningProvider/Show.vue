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
	learningProvider: {
		id: number
		name: string
		slug: string
		business_type: {id: number, name: string }
		first_line: string 
        post_code: string
        person_to_contact: string
        main_email_address: string
        first_phone_number: number
		is_archived: boolean
	}, 
	from: 'index' | 'archived'
}>()

const breadcrumbs: BreadcrumbItem[] = [
	{ title: 'Dashboard', href: route('dashboard') },
	{ title: 'Learning Providers', href: route('learningProviders.index') },
	{ title: 'Details', href: '#' },
]

const page = usePage()
const pageFrom = computed(() => page.props.from ?? 'index')

</script>

<template>
	<AppLayout title="Learning Provider Details" :breadcrumbs="breadcrumbs">
		<Head title="Learning Provider Details" />

		<div class="px-4 sm:px-6 lg:px-8 py-4 sm:py-6 lg:py-8 space-y-6">
			<h1 class="text-3xl font-bold text-gray-900 dark:text-white">Learning Provider Details</h1>

			<div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 space-y-2">
				<p><strong>Name:</strong> {{ learningProvider.name }}</p>
				<p><strong>Business Type:</strong> {{ learningProvider.business_type?.name ?? '-' }}</p>
				<p><strong>Address:</strong> {{ learningProvider?.first_line }} {{ learningProvider?.post_code }}</p>
				<p><strong>Main Contact:</strong> {{ learningProvider.person_to_contact }} {{ learningProvider.first_phone_number }} {{ learningProvider.main_email_address }}</p>
			</div>

			<div class="flex space-x-4">
				<Link 
				 	:href="route('learningProviders.edit', learningProvider.slug)" 
					class="text-sm btn btn-primary"
				>
					Edit
				</Link>
				<Link 
					:href="(props.from ?? pageFrom) === 'archived' ? route('learningProviders.archived') : route('learningProviders.index')" 
					class="text-sm text-muted-foreground"
				>
					Back
				</Link>
			</div>
		</div>
	</AppLayout>
</template>