<script setup lang="ts">
import HeadingSmall from '@/components/HeadingSmall.vue';

import AppLayout from '@/layouts/AppLayout.vue';
import ControlLayout from '@/pages/ControlFlota/Layout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import OperadorForm from './components/OperadorForm.vue';

interface Props {
    status?: string;
}

defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Operadores',
        href: '/control-flota/operadores/index',
    },
    {
        title: 'Nuevo operador',
        href: '/control-flota/operadores/create',
    },
];
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head title="Control Flota - Nuevo operador" />
        <ControlLayout>
            <HeadingSmall title="Nuevo operador" />
            <OperadorForm mode="create" />
        </ControlLayout>
    </AppLayout>
</template>
