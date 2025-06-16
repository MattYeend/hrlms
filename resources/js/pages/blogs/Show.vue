<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3'
import { ref, reactive } from 'vue'
import AppLayout from '@/layouts/AppLayout.vue'
import { type BreadcrumbItem } from '@/types'

const props = defineProps<{
	blog: {
		id: number
		title: string
		content: string
		approved: boolean
		approved_by: { name: string, id: number } | null,
		is_archived: boolean
		slug: string
		created_by: { name: string, id: number }
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

const editingComments = reactive<{ [key: number]: string }>({})
const editingMode = ref<number | null>(null)

function toggleLike() {
	isLiking.value = true
	router.post(route('blog-likes.toggle', { blog: props.blog.slug }), {}, {
		onFinish: () => { isLiking.value = false },
		onSuccess: () => {
			router.reload({ only: ['blog'] })
		}
	})
}

function submitComment() {
	if (!commentText.value.trim()) return
	router.post(route('blogComments.store'), {
		blog_id: props.blog.id,
		comment: commentText.value,
	})
	commentText.value = ''
}

function startEditing(commentId: number, currentText: string) {
	editingMode.value = commentId
	editingComments[commentId] = currentText
}

function cancelEditing() {
	editingMode.value = null
}

function updateComment(commentId: number) {
	const updatedText = editingComments[commentId]?.trim()
	if (!updatedText) return

	router.put(route('blogComments.update', commentId ), {
		comment: updatedText,
	}, {
		onSuccess: () => {
			editingMode.value = null
			router.reload({ only: ['blog'] })
		}
	})
}

function deleteComment(commentId: number) {
	if (!confirm('Are you sure you want to delete this comment?')) return
	router.delete(route('blogComments.destroy', commentId ), {
		preserveScroll: true,
		onSuccess: () => router.reload({ only: ['blog'] })
	})
}

function canEditComment(commentUserId: number): boolean {
	return props.authUser.id === commentUserId
}

function canDeleteComment(commentUserId: number): boolean {
	return (
		props.authUser.id === commentUserId ||
		props.authUser.id === props.blog.created_by.id ||
		props.blog.approved_by?.id === props.authUser.id
	)
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

			<div v-if="blog.approved && !blog.is_archived" class="flex items-center space-x-4 mt-4">
				<button @click="toggleLike" :disabled="isLiking" class="btn btn-sm btn-outline">
					👍 Like ({{ blog.likes_count }})
				</button>
			</div>

			<div v-if="blog.approved && !blog.is_archived" class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
				<h2 class="text-xl font-semibold mb-4">Comments ({{ blog.comments.length }})</h2>

				<div v-if="blog.comments.length === 0" class="text-gray-500">
					No comments yet.
				</div>

				<ul class="space-y-4">
					<li v-for="comment in blog.comments" :key="comment.id" class="border-b border-gray-200 dark:border-gray-700 pb-2">
						<p class="text-sm text-gray-600 dark:text-gray-300">
							<strong>{{ comment.user.name }}</strong>:
						</p>

						<div v-if="editingMode === comment.id">
							<textarea
								v-model="editingComments[comment.id]"
								rows="2"
								class="w-full rounded border-gray-300 dark:bg-gray-700 dark:text-white"
							></textarea>
							<div class="mt-1 space-x-2">
								<button @click="updateComment(comment.id)" class="btn btn-sm btn-primary">Save</button>
								<button @click="cancelEditing" class="btn btn-sm btn-secondary">Cancel</button>
							</div>
						</div>
						<div v-else>
							<p class="text-gray-800 dark:text-white">{{ comment.comment }}</p>
						</div>

						<div class="mt-1 space-x-2 text-sm">
							<button
								v-if="canEditComment(comment.user.id)"
								@click="startEditing(comment.id, comment.comment)"
								class="text-blue-500 hover:underline"
							>
								Edit
							</button>
							<button
								v-if="canDeleteComment(comment.user.id)"
								@click="deleteComment(comment.id)"
								class="text-red-500 hover:underline"
							>
								Delete
							</button>
						</div>
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
				<Link :href="route('blogs.edit', blog.slug)" class="text-sm btn btn-primary">Edit</Link>
				<Link :href="from === 'archived' ? route('blogs.archived') : route('blogs.index')" class="text-sm text-muted-foreground">
					Back
				</Link>
			</div>
		</div>
	</AppLayout>
</template>
