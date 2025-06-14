<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3'
import { ref } from 'vue'
import AppLayout from '@/layouts/AppLayout.vue'
import { type BreadcrumbItem } from '@/types'

const props = defineProps<{
	blog: {
		id: number
		title: string
		content: string
		approved: boolean
		approved_by: { name: string} | null,
		is_archived: boolean
		slug: string
		created_by: { name: string }
		likes_count: number
		comments: { id: number, comment: string, user: { id: number, name: string } }[]
	}
	authUser: {
		id: number
		role: { name: string }
	}
	from: 'index' | 'archived'
}>()

const breadcrumbs: BreadcrumbItem[] = [
	{ title: 'Dashboard', href: route('dashboard') },
	{ title: 'Blogs', href: route('blogs.index') },
	{ title: props.blog.title, href: '#' },
]

const commentText = ref('')
const isLiking = ref(false)

function toggleLike() {
	isLiking.value = true
	router.post(route('blog-likes.toggle', { blog: props.blog.slug }), {}, {
		onFinish: () => {
			isLiking.value = false
		},
		onSuccess: () => {
			router.reload({ only: ['blog'] })
		}
	})
}

function submitComment() {
	if (!commentText.value.trim()) return
	router.post(route('blog-comments.store'), {
		blog_id: props.blog.id,
		comment: commentText.value,
	})
	commentText.value = ''
}
</script>

<template>
	<AppLayout title="Blog Details" :breadcrumbs="breadcrumbs">
		<Head title="Blog Details" />

		<div class="px-4 sm:px-6 lg:px-8 py-4 sm:py-6 lg:py-8 space-y-6">
			<h1 class="text-3xl font-bold text-gray-900 dark:text-white">Blog Details</h1>

			<div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 space-y-2">
				<p><strong>Title:</strong> {{ blog.title }}</p>
				<p><strong>Content:</strong> {{ blog.content }}</p>
				<p><strong>Approved:</strong> {{ blog.approved ? 'Yes' : 'No' }}</p>
				<p><strong>Approved By:</strong> {{ blog.approved_by?.name ?? 'Not yet approved' }}</p>
				<p><strong>Created By:</strong> {{ blog.created_by.name }}</p>
			</div>
			<div 
				v-if="blog.approved && !blog.is_archived" 
				class="flex items-center space-x-4 mt-4"
			>
				<button @click="toggleLike" :disabled="isLiking" class="btn btn-sm btn-outline">
					👍 Like ({{ blog.likes_count }})
				</button>
			</div>
			<div 
				v-if="blog.approved && !blog.is_archived" 
				class="bg-white dark:bg-gray-800 rounded-xl shadow p-6"
			>
				<h2 class="text-xl font-semibold mb-4">Comments ({{ blog.comments.length }})</h2>

				<div 
					v-if="blog.comments.length === 0" 
					class="text-gray-500"
				>
					No comments yet.
				</div>

				<ul class="space-y-4">
					<li 
						v-for="comment in blog.comments" 
						:key="comment.id" 
						class="border-b border-gray-200 dark:border-gray-700 pb-2"
					>
						<p class="text-sm text-gray-600 dark:text-gray-300">
							<strong>{{ comment.user.name }}</strong>:
						</p>
						<p class="text-gray-800 dark:text-white">{{ comment.comment }}</p>
					</li>
				</ul>

				<div class="mt-6 space-y-2">
					<textarea
						v-model="commentText"
						rows="3"
						class="w-full rounded border-gray-300 dark:bg-gray-700 dark:text-white"
						placeholder="Write a comment..."
					></textarea>
					<button @click="submitComment" class="btn btn-primary btn-sm">Post Comment</button>
				</div>
			</div>

			<div class="flex space-x-4">
				<Link 
					:href="route('blogs.edit', blog.slug)" 
					class="text-sm btn btn-primary"
				>
					Edit
				</Link>
				<Link 
					:href="from === 'archived' ? route('blogs.archived') : route('blogs.index')" 
					class="text-sm text-muted-foreground"
				>
					Back
				</Link>
			</div>
		</div>
	</AppLayout>
</template>