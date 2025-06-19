<script setup lang="ts">
import { 
	Head, 
	Link,
	router
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
		url: string
        learning_provider: {id: number, name: string }
        department: {id: number, name: string }
		is_archived: boolean
		started: boolean
		ended: boolean
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

const submitStart = () => {
	router.post(route('learningMaterials.start', props.learningMaterial.slug))
}

const submitEnd = () => {
	router.post(route('learningMaterials.end', props.learningMaterial.slug))
}

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
                <p>
					<strong>File:</strong>
					<a 
						v-if="learningMaterial.file_path" 
						:href="`/storage/${learningMaterial.file_path}`" 
						target="_blank"
						class="text-blue-500 hover:underline"
					>
						Download
					</a>
					<span v-else>-</span>
				</p>
				<p><strong>URL:</strong> {{ learningMaterial.url }}</p>
				<p><strong>Learning Provider:</strong> {{ learningMaterial.learning_provider?.name ?? '-' }}</p>
                <p><strong>Department:</strong> {{ learningMaterial.department?.name ?? '-' }}</p>
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

				<button 
					@click="submitStart" 
					v-if="!learningMaterial.is_archived && !learningMaterial.started" 
					class="text-sm btn btn-success"
				>
				Start
				</button>

				<button 
					@click="submitEnd" 
					v-if="!learningMaterial.is_archived && learningMaterial.started && !learningMaterial.ended" 
					class="text-sm btn btn-secondary"
				>
				End
				</button>
			</div>
		</div>
	</AppLayout>
</template>