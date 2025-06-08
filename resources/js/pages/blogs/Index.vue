<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import { type BreadcrumbItem } from '@/types'
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'

const page = usePage()

defineProps<{
	blogs: Array<{
		id: number
		title: string,
		content: string,
		approved: boolean,
		approved_by: { name: string} | null,
		is_archived: boolean,
		slug: string,
		created_by: number,
	}>
	authUser: {
		id: number,
		role: { name: string }
	}
}>()

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
				<h1 class="text-3xl font-bold text-gray-900 dark:text-white">Blogs</h1>
				<span v-if="isCSuiteOrHrStaff">
					<Link 
						:href="route('blogs.create')" 
						class="text-sm text-blue-600 dark:text-blue-400"
					>
						+ New Blog
					</Link>
				</span>
			</div>

			<div class="overflow-x-auto">
				<table class="min-w-full border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 rounded-md shadow-sm">
					<thead class="bg-gray-100 dark:bg-gray-700">
						<tr>
							<th class="text-left p-3">Title</th>
							<th class="text-left p-3">Content</th>
							<th class="text-left p-3">Status</th>
							<th class="text-left p-3">Reviewed By</th>
							<th class="text-left p-3">Actions</th>
						</tr>
					</thead>
					<tbody>
						<tr 
							v-for="blog in blogs" 
							:key="blog.id" 
							class="hover:bg-gray-50 dark:hover:bg-gray-700 transition"
						>
							<td class="p-3">{{ blog.title }}</td>
							<td class="p-3 line-clamp-2 max-w-md">{{ truncate(blog.content, 100) }}</td>
							<td class="p-3">{{ blog.approved ? 'Yes' : 'Pending' }}</td>
							<td class="p-3">{{ blog.approved_by?.name ? blog.approved_by.name : '-' }}</td>
							<td class="p-3 space-x-2">
								<Link 
									:href="route('blogs.show', blog.slug) + '?from=index'" 
									class="text-sm text-blue-600 dark:text-blue-400"
								>
									View
								</Link>
								<Link 
									v-if="isCSuiteOrHrStaff && (authUser.id === blog.created_by || ['Admin', 'Super Admin'].includes(authUser.role.name))"
									:href="route('blogs.edit', blog.slug)" 
									class="text-sm text-blue-600 dark:text-blue-400"
								>
									Edit
								</Link>
								<Link 
									v-if="['Admin', 'Super Admin'].includes(authUser.role.name) && !blog.approved"
									:href="route('blogs.approve', blog.slug)" 
									method="post" 
									class="text-sm text-blue-600 dark:text-blue-400"
								>
									Approve
								</Link>
								<Link 
									v-if="['Admin', 'Super Admin'].includes(authUser.role.name) && !blog.approved"
									:href="route('blogs.deny', blog.slug)" 
									method="post" 
									class="text-sm text-blue-600 dark:text-blue-400"
								>
									Deny
								</Link>
								<Link 
									v-if="isCSuiteOrHrStaff && ['Admin', 'Super Admin'].includes(authUser.role.name) && authUser.id !== blog.created_by"
									:href="route('blogs.destroy', blog.slug)" 
									method="delete" 
									as="button"
									class="text-sm text-red-600 dark:text-red-400"
								>
									Archive
								</Link>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</AppLayout>
</template>