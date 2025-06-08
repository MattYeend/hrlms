<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import { type BreadcrumbItem } from '@/types'
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'

defineProps<{
	blogs: Array<{
		id: number
		title: string,
		content: string,
		approved: boolean,
		approved_by: { name: string} | null,
		is_archived: boolean
		slug: string
		created_by: number
	}>
	authUser: {
		id: number
		role: { name: string }
	}
}>()

const page = usePage()
const isCSuiteOrHrStaff = computed(() => page.props.isCSuiteOrHrStaff)

const breadcrumbs: BreadcrumbItem[] = [
	{ title: 'Dashboard', href: route('dashboard') },
	{ title: 'Blogs', href: route('blogs.index') },
]

const truncate = (text: string, length = 100) => {
	return text.length > length ? text.slice(0, length) + '…' : text
}
</script>

<template>
	<AppLayout title="Blogs" :breadcrumbs="breadcrumbs">
		<Head title="Blogs" />

		<div class="px-4 sm:px-6 lg:px-8 py-4 sm:py-6 lg:py-8">
			<div class="flex justify-between items-center mb-6">
				<h1 class="text-3xl font-bold text-gray-900 dark:text-white">Archived Blogs</h1>
			</div>

			<div class="overflow-x-auto">
				<table class="min-w-full border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 rounded-md shadow-sm">
					<thead class="bg-gray-100 dark:bg-gray-700">
						<tr>
							<th class="text-left p-3">Title</th>
							<th class="text-left p-3">Content</th>
							<th class="text-left p-3">Approved</th>
							<th class="text-left p-3">Approved By</th>
							<th class="text-left p-3">Actions</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="blog in blogs" :key="blog.id" class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
							<td class="p-3">{{ blog.title }}</td>
							<td class="p-3 line-clamp-2 max-w-md">{{ truncate(blog.content, 100) }}</td>
							<td class="p-3">{{ blog.approved ? 'Yes' : 'No' }}</td>
							<td class="p-3">{{ blog.approved_by?.name ?? 'Not yet approved' }}</td>
							<td class="p-3 space-x-2">
								<Link 
									:href="route('blogs.show', { slug: blog.slug }) + `?from=archived`"
									class="text-sm text-blue-600 dark:text-blue-400"
								>
									View
								</Link>
								<Link 
									v-if="isCSuiteOrHrStaff && ['Admin', 'Super Admin'].includes(authUser.role.name) && authUser.id !== blog.created_by"
									:href="route('blogs.restore', blog.slug)"
									:method="'post'" 
									as="button"
									class="text-sm text-red-600 dark:text-red-400"
								>
					  				{{ 'Restore'}}
								</Link>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</AppLayout>
</template>