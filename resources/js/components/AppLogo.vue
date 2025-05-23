<script setup lang="ts">
import AppLogoIcon from '@/components/AppLogoIcon.vue';
import { usePage } from '@inertiajs/vue3'; // Import usePage
import { computed } from 'vue'; // Import computed for reactive access
const page = usePage();
const appName = computed(() => page.props.name);
</script>

<template>
    <div class="text-sidebar-primary-foreground flex aspect-square size-8 items-center justify-center rounded-md">
        <AppLogoIcon class="size-6 fill-current text-white dark:text-black" />
    </div>
    <div class="ml-1 grid flex-1 text-left text-sm">
        <span class="mb-0.5 truncate leading-none font-semibold">{{ appName }}</span>
    </div>
</template>
