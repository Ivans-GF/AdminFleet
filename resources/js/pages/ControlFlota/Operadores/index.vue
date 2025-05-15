<script setup lang="ts">
import HeadingSmall from '@/components/HeadingSmall.vue';
import { Card, CardContent, CardFooter, CardTitle } from '@/components/ui/card';
import CardDescription from '@/components/ui/card/CardDescription.vue';
import CardHeader from '@/components/ui/card/CardHeader.vue';

import AppLayout from '@/layouts/AppLayout.vue';
import ControlLayout from '@/pages/ControlFlota/Layout.vue';
import { type BreadcrumbItem, type SharedData } from '@/types';
import { Head, usePage } from '@inertiajs/vue3';

interface Props {
    status?: string;
}

defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Operadores',
        href: '/control-flota/operadores/index',
    },
];

const page = usePage<SharedData>();
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head title="Control Flota - Operadores" />
        <ControlLayout>
            <HeadingSmall title="Operadores" />
            <Card>
                <CardHeader>
                    <CardTitle> Card Title </CardTitle>
                    <CardDescription> Card Description </CardDescription>
                </CardHeader>
                <CardContent> Card Content </CardContent>
                <CardFooter> Card Footer </CardFooter>
            </Card>
        </ControlLayout>
    </AppLayout>
</template>
