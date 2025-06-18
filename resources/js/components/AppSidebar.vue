<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavUser from '@/components/NavUser.vue';
import { 
	Sidebar, 
	SidebarContent, 
	SidebarFooter, 
	SidebarHeader, 
	SidebarMenu, 
	SidebarMenuButton, 
	SidebarMenuItem 
} from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { 
	Link, 
	usePage 
} from '@inertiajs/vue3';
import { 
	BookOpen, 
	Folder, 
	LayoutGrid, 
	ShieldCheck, 
	User2Icon, 
	ArchiveIcon, 
	Building2, 
	Layers2, 
	Library
} from 'lucide-vue-next';
import AppLogo from './AppLogo.vue';
import { computed } from 'vue';

const page = usePage();
// const isSuperAdmin = computed(() => page.props.auth?.user?.role_id === 1);
const isAtleastAdmin = computed(() => page.props.auth?.user?.role_id === 1 || page.props.auth?.user?.role_id === 2);
const isHighLevelOrHrStaff = computed(() => page.props.auth?.user?.isHighLevelOrHrStaff);
const archivedUsers = computed(() => page.props.archivedUsers);
const archivedDepts = computed(() => page.props.archivedDepts);
const archivedJobs = computed(() => page.props.archivedJobs);
const archivedBlogs = computed(() => page.props.archivedBlogs);
const deniedBlogs = computed(() => page.props.deniedBlogs);
const archivedLearningProviders = computed(() => page.props.archivedLearningProviders);
const archivedQuizzes = computed(() => page.props.archivedQuizzes);
const archivedLearningMaterials = computed(() => page.props.archivedLearningMaterials);

const mainNavItems = computed<NavItem[]>(() => {
	const items: NavItem[] = [];

	const dashboadItem: NavItem = {
		title: 'Dashboard',
		href: '/dashboard',
		icon: LayoutGrid,
	};
	items.push(dashboadItem);

	const blogItems: NavItem = {
		title: 'Blogs',
		href: '/blogs',
		icon: BookOpen,
		children: [],
	};
	if(isAtleastAdmin.value && archivedBlogs.value) {
		blogItems.children!.push({
			title: 'Archived Blogs',
			href: '/blogs/archived',
			icon: ArchiveIcon,
		})
	}
	if(isAtleastAdmin && deniedBlogs.value) {
		blogItems.children!.push({
			title: 'Denied Blogs',
			href: '/blogs/denied',
			icon: ArchiveIcon,
		})
	}
	items.push(blogItems);

	const departmentsItem: NavItem = {
		title: 'Departments',
		href: '/departments',
		icon: Layers2,
		children: [],
	};
	if (archivedDepts.value) {
		departmentsItem.children!.push({
			title: 'Archived Departments',
			href: '/departments/archived',
			icon: ArchiveIcon,
		});
	}
	items.push(departmentsItem);

	const jobsItem: NavItem = {
		title: 'Jobs',
		href: '/jobs',
		icon: Folder,
		children: [],
	};
	if (isAtleastAdmin.value && archivedJobs.value && isHighLevelOrHrStaff) {
		jobsItem.children!.push({
			title: 'Archived Jobs',
			href: '/jobs/archived',
			icon: ArchiveIcon,
		});
	}
	items.push(jobsItem);

	const learningMaterialItem: NavItem = {
		title: 'Learning Materials',
		href: '/learningMaterials',
		icon: Library,
		children: []
	};
	if (isAtleastAdmin.value && archivedLearningMaterials.value){
		learningMaterialItem.children!.push({
			title: 'Archived Learning Materials',
			href: '/learningMaterials/archived',
			icon: ArchiveIcon,
		});
	}
	items.push(learningMaterialItem);

	const learningProviderItem: NavItem = {
		title: 'Learning Providers',
		href: '/learningProviders',
		icon: Library,
		children: [],
	};
	if (isAtleastAdmin.value && archivedLearningProviders.value){
		learningProviderItem.children!.push({
			title: 'Archived Learning Providers',
			href: '/learningProviders/archived',
			icon: ArchiveIcon,
		});
	}
	items.push(learningProviderItem);

	const quizItem: NavItem = {
		title: 'Quizzes',
		href: '/quizzes',
		icon: BookOpen,
		children: [],
	};
	if (isAtleastAdmin && archivedQuizzes.value){
		quizItem.children!.push({
			title: 'Archived Quizzes',
			href: '/quizzes/archived',
			icon: ArchiveIcon,
		});
	}
	items.push(quizItem);
	
	if (isAtleastAdmin.value) {
		items.push({
			title: 'Roles',
			href: '/roles',
			icon: ShieldCheck,
		});
	}

	const usersItem: NavItem = {
		title: 'Users',
		href: '/users',
		icon: User2Icon,
		children: [],
	};
	if (isAtleastAdmin.value && archivedUsers.value && isHighLevelOrHrStaff) {
		usersItem.children!.push({
			title: 'Archived Users',
			href: '/users/archived',
			icon: ArchiveIcon,
		});
	}
	items.push(usersItem);

	return items;
});

const footerNavItems: NavItem[] = [
	{
		title: 'Github Repo',
		href: 'https://github.com/laravel/vue-starter-kit',
		icon: Folder,
	},
	{
		title: 'Documentation',
		href: 'https://laravel.com/docs/starter-kits#vue',
		icon: BookOpen,
	},
];
</script>

<template>
		<Sidebar collapsible="icon" variant="inset">
				<SidebarHeader>
						<SidebarMenu>
								<SidebarMenuItem>
										<SidebarMenuButton size="lg" as-child>
												<Link :href="route('dashboard')">
														<AppLogo />
												</Link>
										</SidebarMenuButton>
								</SidebarMenuItem>
						</SidebarMenu>
				</SidebarHeader>

				<SidebarContent>
					<nav>
						<ul>
							<li v-for="item in mainNavItems" :key="item.title" class="mb-1">
								<Link :href="item.href" class="flex items-center gap-2 px-3 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700">
									<component v-if="item.icon" :is="item.icon" class="h-5 w-5" />
									<span>{{ item.title }}</span>
								</Link>
								
								<ul v-if="item.children?.length" class="ml-6 mt-1 space-y-1 border-l border-gray-300 dark:border-gray-700 pl-3">
									<li v-for="child in item.children" :key="child.title">
										<Link
											:href="child.href"
											class="flex items-center gap-2 px-3 py-1 rounded text-sm hover:bg-gray-200 dark:hover:bg-gray-700"
										>
											<component v-if="child.icon" :is="child.icon" class="h-4 w-4" />
											<span>{{ child.title }}</span>
										</Link>
									</li>
								</ul>
							</li>
						</ul>
					</nav>
				</SidebarContent>

				<SidebarFooter>
						<NavFooter :items="footerNavItems" />
						<NavUser />
				</SidebarFooter>
		</Sidebar>
		<slot />
</template>
