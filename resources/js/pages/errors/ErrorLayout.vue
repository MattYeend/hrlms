<template>
	<AppLayout :title="title" :breadcrumbs="breadcrumbs">
    	<PlaceholderPattern class="absolute inset-0 opacity-5 pointer-events-none" />
		<Head :title="title" />
	    <div class="flex flex-col items-center justify-center min-h-[60vh] text-center px-4 relative z-10">
			<h1 class="text-7xl font-extrabold text-red-600">{{ code }}</h1>
			<p class="mt-4 text-2xl font-semibold text-gray-800">{{ message }}</p>
			<Link :href="route('dashboard')" class="mt-6 text-blue-500 underline">
			Return Home
			</Link>
	    </div>
    </AppLayout>
</template>
  
<script setup lang="ts">
import { Link, Head } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import PlaceholderPattern from '../../components/PlaceholderPattern.vue';
import { type BreadcrumbItem } from '@/types';

const props = defineProps<{
	code: number;
	message: string;
}>();
  
const title = `Error ${props.code}`;
  
const breadcrumbs: BreadcrumbItem[] = [
	{ title: 'Dashboard', href: route('dashboard') },
];
</script>