<script setup lang="ts">
import { Head, usePage } from '@inertiajs/vue3';

import HeadingSmall from '@/components/HeadingSmall.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import ControlLayout from '@/pages/ControlFlota/Layout.vue';
import { type BreadcrumbItem, type SharedData } from '@/types';

interface Props {
    status?: string;
}

defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Unidades',
        href: '/control-flota/unidades/index',
    },
];

const page = usePage<SharedData>();
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head title="Control - Flota Unidades" />
        <ControlLayout>
            <div class="flex flex-col space-y-6">
                <HeadingSmall title="Unidades" />
            </div>
        </ControlLayout>
    </AppLayout>
</template>
