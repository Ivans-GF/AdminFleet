<script setup lang="ts">
import HeadingSmall from '@/components/HeadingSmall.vue';
import { Card, CardContent, CardTitle } from '@/components/ui/card';
import CardHeader from '@/components/ui/card/CardHeader.vue';
import { CirclePlus, Menu } from 'lucide-vue-next';

import Button from '@/components/ui/button/Button.vue';
import DropdownMenu from '@/components/ui/dropdown-menu/DropdownMenu.vue';
import DropdownMenuContent from '@/components/ui/dropdown-menu/DropdownMenuContent.vue';
import DropdownMenuItem from '@/components/ui/dropdown-menu/DropdownMenuItem.vue';
import DropdownMenuLabel from '@/components/ui/dropdown-menu/DropdownMenuLabel.vue';
import DropdownMenuSeparator from '@/components/ui/dropdown-menu/DropdownMenuSeparator.vue';
import DropdownMenuTrigger from '@/components/ui/dropdown-menu/DropdownMenuTrigger.vue';
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
                    <CardTitle>
                        <div class="flex flex-row justify-end space-x-2">
                            <Button :href="route('operadores/create')"> <CirclePlus class="mr-2 h-4 w-4" />Nuevo operador</Button>
                            <DropdownMenu>
                                <DropdownMenuTrigger>
                                    <Button variant="secondary"><Menu class="mr-2 h-4 w-4" />Opciones</Button>
                                </DropdownMenuTrigger>
                                <DropdownMenuContent>
                                    <DropdownMenuLabel>Opciones</DropdownMenuLabel>
                                    <DropdownMenuSeparator />
                                    <DropdownMenuItem><Menu class="mr-2 h-4 w-4" />Requerimientos</DropdownMenuItem>
                                </DropdownMenuContent>
                            </DropdownMenu>
                        </div>
                    </CardTitle>
                </CardHeader>
                <CardContent> Card Content </CardContent>
            </Card>
        </ControlLayout>
    </AppLayout>
</template>
