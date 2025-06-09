<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, usePage } from '@inertiajs/vue3';
import PlaceholderPattern from '../components/PlaceholderPattern.vue';
import DepartmentStats from '@/components/DepartmentStats.vue';
import UserStats from '@/components/UserStats.vue';

const breadcrumbs: BreadcrumbItem[] = [
	{
		title: 'Dashboard',
		href: '/dashboard',
	},
];

type DashboardData = {
	departmentCount: number;
	userCount: number;
	archivedDepartmentCount: number;
	archivedUserCount: number;
};

const page = usePage();

const {
	departmentCount,
	userCount,
	archivedDepartmentCount,
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
					<PlaceholderPattern />
				</div>
				<div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
					<DepartmentStats
						:departmentCount="departmentCount"
						:archivedDepartmentCount="archivedDepartmentCount"
						:authUser="authUser"
					/>
				</div>
				<div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
					<UserStats
						:userCount="userCount"
						:archivedUserCount="archivedUserCount"
						:authUser="authUser"
					/>
				</div>
			</div>
			<div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min">
				<PlaceholderPattern />
			</div>
		</div>
	</AppLayout>
</template>
