<script setup lang="ts">
import HeadingSmall from '@/components/HeadingSmall.vue';
import Button from '@/components/ui/button/Button.vue';
import { Card, CardContent, CardTitle } from '@/components/ui/card';
import { DropdownMenu, DropdownMenuContent, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import AppLayout from '@/layouts/AppLayout.vue';
import ControlLayout from '@/pages/ControlFlota/Layout.vue';
import { type BreadcrumbItem, type Operador } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import { Camera, ChevronsUpDown, CirclePlus, ClipboardPlus, EllipsisVertical, IdCard, Menu, UserPen } from 'lucide-vue-next';
import { h } from 'vue';
import MydataTable from '@/components/mycomponents/Datatable/MyDataTable.vue';
import CardHeader from '@/components/ui/card/CardHeader.vue';
import DropdownMenuItem from '@/components/ui/dropdown-menu/DropdownMenuItem.vue';
import DropdownMenuLabel from '@/components/ui/dropdown-menu/DropdownMenuLabel.vue';
import DropdownMenuSeparator from '@/components/ui/dropdown-menu/DropdownMenuSeparator.vue';
import { createColumnHelper, type ColumnDef } from '@tanstack/vue-table'; // Make sure ColumnDef is imported here too!

// Import the new DataTable component
const props = defineProps<{
    operadores: Operador[];
}>();

const data = props.operadores || [];

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Operadores',
        href: route('operadores.index'),
    },
];
const columnHelper = createColumnHelper<Operador>();

const columns = [
    //Boton acciones
    columnHelper.display({
        id: 'actions', // Unique ID for this column
        header: '---', // Header text for the column
        cell: ({ row }) => {
            // Get the original data object for the current row
            const operador = row.original;
            return h('div', { class: 'flex justify-center items-center h-full' }, [
                // Centering container
                h(DropdownMenu, {}, [
                    h(
                        DropdownMenuTrigger,
                        {},
                        h(Button, { size: 'lg', variant: 'ghost' }, () => h(EllipsisVertical)),
                    ),
                    // FIX: Wrap the DropdownMenuContent children in a function for the default slot
                    h(DropdownMenuContent, {}, () => [
                        // Changed from array directly to a function returning the array
                        h(
                            DropdownMenuItem,
                            { value: 'bottom' },
                            h(Link, { href: route('operadores.edit', operador.id), class: 'flex items-center' }, () => [
                                h(UserPen, { class: 'mr-2 h-4 w-4' }),
                                'Modificar datos',
                            ]),
                        ),
                        h(
                            DropdownMenuItem,
                            { value: 'bottom' },
                            h(Link, { href: route('operadores.gestionlicencia', operador.id), class: 'flex items-center' }, () => [
                                h(Camera, { class: 'mr-2 h-4 w-4' }),
                                'Gestión foto',
                            ]),
                        ),
                        h(DropdownMenuSeparator),
                        h(
                            DropdownMenuItem,
                            { value: 'bottom' },
                            h(Link, { href: route('operadores.gestionlicencia', operador.id), class: 'flex items-center' }, () => [
                                h(IdCard, { class: 'mr-2 h-4 w-4' }),
                                'Gestión licencia',
                            ]),
                        ),
                        h(
                            DropdownMenuItem,
                            { value: 'bottom' },
                            h(Link, { href: route('operadores.gestionlicencia', operador.id), class: 'flex items-center' }, () => [
                                h(ClipboardPlus, { class: 'mr-2 h-4 w-4' }),
                                'Gestión acto medico',
                            ]),
                        ),
                    ]),
                ]),
            ]);
        },
        enableHiding: false, // Normalmente no se ocultan las columnas de acciones
        enableSorting: false, // Las columnas de acciones no se pueden ordenar
        enableColumnFilter: false, // Las columnas de acciones no se pueden filtrar
    }),
    //Campo nombre completo
    columnHelper.accessor((row) => `${row.nombre} ${row.apellido}`.trim(), {
        id: 'Nombre completo',
        header: ({ column }) => {
            return h(
                Button,
                {
                    variant: 'ghost',
                    onClick: () => column.toggleSorting(column.getIsSorted() === 'asc'),
                },
                () => ['Nombre completo', h(ChevronsUpDown, { class: 'ml-2 h-4 w-4' })],
            );
        },
        cell: (info) => info.getValue(),
        enableSorting: true,
        enableHiding: true,
        enableColumnFilter: true, // Crucial: Enable filtering for this column
    }),
    //Campo telefono
    columnHelper.accessor((row) => `${row.telefono}`.trim(), {
        id: 'telefono',
        header: ({ column }) => {
            return h(
                Button,
                {
                    variant: 'ghost',
                    onClick: () => column.toggleSorting(column.getIsSorted() === 'asc'),
                },
                () => ['Teléfono', h(ChevronsUpDown, { class: 'ml-2 h-4 w-4' })],
            );
        },
        cell: (info) => info.getValue(),
        enableSorting: true,
        enableHiding: true,
        enableColumnFilter: false,
        enableGlobalFilter: false,
    }),
] as ColumnDef<any>[];
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
                            <DropdownMenu>
                                <DropdownMenuTrigger>
                                    <Button variant="secondary"><Menu class="mr-2 h-4 w-4" />Opciones</Button>
                                </DropdownMenuTrigger>
                                <DropdownMenuContent>
                                    <DropdownMenuLabel>Opciones</DropdownMenuLabel>
                                    <DropdownMenuSeparator />
                                    <DropdownMenuItem><Menu class="mr-2 h-4 w-4" />Documentación</DropdownMenuItem>
                                </DropdownMenuContent>
                            </DropdownMenu>
                            <Button as-child>
                                <Link :href="route('operadores.create')"> <CirclePlus class="mr-2 h-4 w-4" />Nuevo operador</Link>
                            </Button>
                        </div>
                    </CardTitle>
                </CardHeader>
                <CardContent>
                    <MydataTable :columns="columns" :data="data" />
                </CardContent>
            </Card>
        </ControlLayout>
    </AppLayout>
</template>
