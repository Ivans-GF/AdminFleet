<script setup lang="ts">
import HeadingSmall from '@/components/HeadingSmall.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import ControlLayout from '@/pages/ControlFlota/Layout.vue';
import { type BreadcrumbItem, type Operador } from '@/types';
import { Head } from '@inertiajs/vue3';
import OperadorForm from './components/OperadorForm.vue';

interface Props {
    operador: Operador;
}

defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Operadores',
        href: route('operadores.index'),
    },
    {
        title: 'Editar operador',
        href: route('operadores.create'),
    },
];
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head title="Control Flota - Editar operador" />
        <ControlLayout>
            <HeadingSmall title="Editar operador" />
            <OperadorForm mode="edit" :operador="operador" />
        </ControlLayout>
    </AppLayout>
</template>
