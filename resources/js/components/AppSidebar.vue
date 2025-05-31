<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';
import { BookOpen, Folder, LayoutGrid } from 'lucide-vue-next';
import AppLogo from './AppLogo.vue';
import { computed } from 'vue';

const page = usePage();
const isSuperAdmin = computed(() => page.props.auth?.user?.role_id === 1);
const isAtleastAdmin = computed(() => page.props.auth?.user?.role_id === 1 || page.props.auth?.user?.role_id === 2);
const hasArchivedUsers = computed(() => page.props.hasArchivedUsers);

const mainNavItems = computed<NavItem[]>(() => {
  const items: NavItem[] = [
    {
      title: 'Dashboard',
      href: '/dashboard',
      icon: LayoutGrid,
    },
    {
      title: 'Users',
      href: '/users',
      icon: LayoutGrid,
      children: [],
    },
  ];
  if (isAtleastAdmin.value) {
    items.push({
      title: 'Roles',
      href: '/roles',
      icon: LayoutGrid,
    });
    items.push({
      title: 'Departments',
      href: '/departments',
      icon: LayoutGrid,
    });
    if (hasArchivedUsers.value) {
      const usersItem = items.find(item => item.title === 'Users');
      if (usersItem) {
        usersItem.children?.push({
          title: 'Archived Users',
          href: '/users/archived',
          icon: LayoutGrid,
        });
      }
    }
  }
  if (isSuperAdmin.value) {
    // items.push({
    //   title: 'Companies',
    //   href: '/companies',
    //   icon: LayoutGrid,
    // });
  }

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
