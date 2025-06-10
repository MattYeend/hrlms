<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, usePage } from '@inertiajs/vue3';
import BlogStats from '@/components/BlogStats.vue';
import DepartmentStats from '@/components/DepartmentStats.vue';
import LearningProvider from '@/components/LearningProviderStats.vue';
import UserStats from '@/components/UserStats.vue';

const breadcrumbs: BreadcrumbItem[] = [
	{
		title: 'Dashboard',
		href: '/dashboard',
	},
];

type DashboardData = {
	text: string;
	blogCount: number;
	departmentCount: number;
	learningProviderCount: number;
	userCount: number;
	archivedBlogCount: number;
	archivedDepartmentCount: number;
	archivedLearningProviderCount: number;
	archivedUserCount: number;
};

const page = usePage();

const {
	text,
	blogCount,
	departmentCount,
	learningProviderCount,
	userCount,
	archivedBlogCount,
	archivedDepartmentCount,
	archivedLearningProviderCount,
	archivedUserCount,
} = ((page.props as unknown) as { data: DashboardData }).data;

const authUser = (page.props as any).authUser;
</script>

<template>
	<Head title="Dashboard" />

	<AppLayout :breadcrumbs="breadcrumbs">
		<div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
			<div class="grid auto-rows-min gap-4 md:grid-cols-3">
				<div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
					<DepartmentStats
						:departmentCount="departmentCount"
						:archivedDepartmentCount="archivedDepartmentCount"
						:authUser="authUser"
						:text="text"
					/>
				</div>
				<div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
					<LearningProvider
						:learningProviderCount="learningProviderCount"
						:archivedLearningProviderCount="archivedLearningProviderCount"
						:authUser="authUser"
						:text="text"
					/>
				</div>
				<div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
					<UserStats
						:userCount="userCount"
						:archivedUserCount="archivedUserCount"
						:authUser="authUser"
						:text="text"
					/>
				</div>
			</div>
			<div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min">
				<BlogStats 
					:blogCount="blogCount"
					:archivedBlogCount="archivedBlogCount"
					:authUser="authUser"
					:text="text"
				/>
			</div>
		</div>
	</AppLayout>
</template>
