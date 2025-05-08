<template>
    <div class="flex flex-col items-center justify-center min-h-screen bg-gray-100 text-center px-4">
        <h1 class="text-7xl font-extrabold text-red-600">{{ code }}</h1>
        <p class="mt-4 text-2xl font-semibold text-gray-800">{{ message }}</p>
        <Link :href="route('dashboard')">
            Return Home
        </Link>
    </div>
</template>
  
<script setup>
    defineProps({
        code: Number,
        message: String
    });
</script>