<script setup lang="ts">
import HeadingSmall from '@/components/HeadingSmall.vue';

import AppLayout from '@/layouts/AppLayout.vue';
import ControlLayout from '@/pages/ControlFlota/Layout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Operadores',
        href: route('operadores.index'),
    },
    {
        title: 'Gestión de licencia',
        href: route('operadores.create'),
    },
];
defineProps<{}>();
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head title="Control Flota - Gestión de licencia" />
        <ControlLayout>
            <HeadingSmall title="Gestión de licencia" />
        </ControlLayout>
    </AppLayout>
</template>
