<script setup lang="ts">
import HeadingSmall from '@/components/HeadingSmall.vue';
import { Card, CardContent, CardTitle } from '@/components/ui/card';
import CardHeader from '@/components/ui/card/CardHeader.vue';
import { CirclePlus, Menu } from 'lucide-vue-next';

import { Badge } from '@/components/ui/badge';
import Button from '@/components/ui/button/Button.vue';
import DropdownMenu from '@/components/ui/dropdown-menu/DropdownMenu.vue';
import DropdownMenuContent from '@/components/ui/dropdown-menu/DropdownMenuContent.vue';
import DropdownMenuItem from '@/components/ui/dropdown-menu/DropdownMenuItem.vue';
import DropdownMenuLabel from '@/components/ui/dropdown-menu/DropdownMenuLabel.vue';
import DropdownMenuSeparator from '@/components/ui/dropdown-menu/DropdownMenuSeparator.vue';
import DropdownMenuTrigger from '@/components/ui/dropdown-menu/DropdownMenuTrigger.vue';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import AppLayout from '@/layouts/AppLayout.vue';
import ControlLayout from '@/pages/ControlFlota/Layout.vue';
import { type BreadcrumbItem, type SharedData } from '@/types';
import { Head, Link, usePage } from '@inertiajs/vue3';

defineProps({
    operadores: {
        type: Array,
        required: true,
    },
});

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Operadores',
        href: route('operadores.index'),
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
                            <Button as-child size="sm">
                                <Link :href="route('operadores.create')"> <CirclePlus class="mr-2 h-4 w-4" />Nuevo operador</Link>
                            </Button>
                            <DropdownMenu>
                                <DropdownMenuTrigger>
                                    <Button size="sm" variant="secondary"><Menu class="mr-2 h-4 w-4" />Opciones</Button>
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
                <CardContent>
                    <div class="flex h-full flex-1 flex-col gap-2 rounded-xl p-2">
                        <Table>
                            <TableHeader>
                                <TableRow>
                                    <TableHead>Estatus</TableHead>
                                    <TableHead>Nombre operador</TableHead>
                                    <TableHead>Teléfono</TableHead>
                                    <TableHead>Indicadores</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                <TableRow v-for="operador in operadores" :key="operador.id">
                                    <TableCell class="flex items-center justify-center">
                                        <Badge
                                            :class="{
                                                'bg-red-500 text-white': operador.estatus === 0,
                                                'bg-green-500 text-white': operador.estatus === 1,
                                            }"
                                        >
                                            {{ operador.estatus === 0 ? 'Atención' : 'Correcto' }}
                                        </Badge>
                                    </TableCell>
                                    <TableCell>{{ operador.nombre }} {{ operador.apellido }}</TableCell>
                                    <TableCell>{{ operador.telefono }}</TableCell>
                                    <TableCell>--</TableCell>
                                </TableRow>
                            </TableBody>
                        </Table>
                    </div>
                </CardContent>
            </Card>
        </ControlLayout>
    </AppLayout>
</template>
