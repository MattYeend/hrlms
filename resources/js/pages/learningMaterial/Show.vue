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
	learningMaterial: {
		id: number
		title: string
		slug: string
        key_objectives: string
        description: string
        file_path: string
        learning_provider: {id: number, name: string }
        department: {id: number, name: string }
		is_archived: boolean
	}, 
	from: 'index' | 'archived'
}>()

const breadcrumbs: BreadcrumbItem[] = [
	{ title: 'Dashboard', href: route('dashboard') },
	{ title: 'Learning Material', href: route('learningMaterials.index') },
	{ title: 'Details', href: '#' },
]

const page = usePage()
const pageFrom = computed(() => page.props.from ?? 'index')

</script>

<template>
	<AppLayout title="Learning Material Details" :breadcrumbs="breadcrumbs">
		<Head title="Learning Material Details" />

		<div class="px-4 sm:px-6 lg:px-8 py-4 sm:py-6 lg:py-8 space-y-6">
			<h1 class="text-3xl font-bold text-gray-900 dark:text-white">Learning Material Details</h1>

			<div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 space-y-2">
				<p><strong>Title:</strong> {{ learningMaterial.title }}</p>
                <p><strong>Key Objectives:</strong> {{ learningMaterial.key_objectives }}</p>
                <p><strong>Description:</strong> {{ learningMaterial.description }}</p>
                <p><strong>File:</strong> {{ learningMaterial.file_path }}</p>
				<p><strong>Learning Provider:</strong> {{ learningMaterial.learning_provider?.name ?? '-' }}</p>
				<p><strong>Department:</strong> {{ learningMaterial.learning_provider?.name ?? '-' }}</p>
			</div>

			<div class="flex space-x-4">
				<Link 
				 	:href="route('learningMaterials.edit', learningMaterial.slug)" 
					class="text-sm btn btn-primary"
				>
					Edit
				</Link>
				<Link 
					:href="(props.from ?? pageFrom) === 'archived' ? route('learningMaterials.archived') : route('learningMaterials.index')" 
					class="text-sm text-muted-foreground"
				>
					Back
				</Link>
			</div>
		</div>
	</AppLayout>
</template>