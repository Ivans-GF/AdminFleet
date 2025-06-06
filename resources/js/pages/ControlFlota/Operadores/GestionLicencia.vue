<script setup lang="ts">
import HeadingSmall from '@/components/HeadingSmall.vue';
import Button from '@/components/ui/button/Button.vue';
import Card from '@/components/ui/card/Card.vue';
import CardContent from '@/components/ui/card/CardContent.vue';
import CardHeader from '@/components/ui/card/CardHeader.vue';
import CardTitle from '@/components/ui/card/CardTitle.vue';

import AppLayout from '@/layouts/AppLayout.vue';
import ControlLayout from '@/pages/ControlFlota/Layout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { CirclePlus, Link } from 'lucide-vue-next';

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
            <Card>
                <CardHeader>
                    <CardTitle>
                        <div class="flex flex-row justify-end space-x-2">
                            <Button as-child size="sm">
                                <Link :href="route('operadores.create')"> <CirclePlus class="mr-2 h-4 w-4" />Nuevo operador</Link>
                            </Button>
                        </div></CardTitle
                    >
                </CardHeader>
                <CardContent> </CardContent>
            </Card>
        </ControlLayout>
    </AppLayout>
</template>
