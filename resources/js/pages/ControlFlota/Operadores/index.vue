<script setup lang="ts">
import HeadingSmall from '@/components/HeadingSmall.vue';
import Button from '@/components/ui/button/Button.vue';
import { Card, CardContent, CardTitle } from '@/components/ui/card';
import { DropdownMenu, DropdownMenuContent, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import Input from '@/components/ui/input/Input.vue'; // Asegúrate de que esta ruta sea correcta
import Table from '@/components/ui/table/Table.vue'; // Asegúrate de que esta ruta sea correcta
import TableBody from '@/components/ui/table/TableBody.vue'; // Asegúrate de que esta ruta sea correcta
import TableCell from '@/components/ui/table/TableCell.vue'; // Asegúrate de que esta ruta sea correcta
import TableHead from '@/components/ui/table/TableHead.vue'; // Asegúrate de que esta ruta sea correcta
import TableHeader from '@/components/ui/table/TableHeader.vue'; // Asegúrate de que esta ruta sea correcta
import TableRow from '@/components/ui/table/TableRow.vue'; // Asegúrate de que esta ruta sea correcta

import AppLayout from '@/layouts/AppLayout.vue';
import ControlLayout from '@/pages/ControlFlota/Layout.vue';
import { type BreadcrumbItem, type Operador } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import { Camera, ChevronDown, ChevronsUpDown, CirclePlus, ClipboardPlus, EllipsisVertical, IdCard, Menu, UserPen } from 'lucide-vue-next'; // Añadido ChevronDown
import { h, ref } from 'vue'; // Añadido watchEffect para depuración

import CardHeader from '@/components/ui/card/CardHeader.vue';
import DropdownMenuCheckboxItem from '@/components/ui/dropdown-menu/DropdownMenuCheckboxItem.vue'; // Asegúrate de que esta ruta sea correcta
import DropdownMenuItem from '@/components/ui/dropdown-menu/DropdownMenuItem.vue';
import DropdownMenuLabel from '@/components/ui/dropdown-menu/DropdownMenuLabel.vue';
import DropdownMenuSeparator from '@/components/ui/dropdown-menu/DropdownMenuSeparator.vue';
import { valueUpdater } from '@/components/ui/table/utils';
import { cn } from '@/lib/utils';
import {
    ColumnFiltersState,
    createColumnHelper,
    ExpandedState,
    FlexRender,
    getCoreRowModel,
    getExpandedRowModel,
    getFilteredRowModel,
    getPaginationRowModel,
    getSortedRowModel,
    SortingState,
    useVueTable,
    VisibilityState,
} from '@tanstack/vue-table';

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
            return h(DropdownMenu, {}, [
                h(
                    DropdownMenuTrigger,
                    {},
                    h(Button, { size: 'lg', variant: 'ghost' }, () => h(EllipsisVertical)),
                ),
                h(DropdownMenuContent, {}, [
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
];

const sorting = ref<SortingState>([]);
const columnFilters = ref<ColumnFiltersState>([]);
const columnVisibility = ref<VisibilityState>({});
const rowSelection = ref({});
const expanded = ref<ExpandedState>({});
const globalFilter = ref(''); // Nuevo estado para el filtro global

const table = useVueTable({
    data,
    columns,
    getCoreRowModel: getCoreRowModel(),
    getPaginationRowModel: getPaginationRowModel(),
    getSortedRowModel: getSortedRowModel(),
    getFilteredRowModel: getFilteredRowModel(), // Necesario para el filtro global
    getExpandedRowModel: getExpandedRowModel(),
    onSortingChange: (updaterOrValue) => valueUpdater(updaterOrValue, sorting),
    onColumnFiltersChange: (updaterOrValue) => valueUpdater(updaterOrValue, columnFilters),
    onColumnVisibilityChange: (updaterOrValue) => valueUpdater(updaterOrValue, columnVisibility),
    onRowSelectionChange: (updaterOrValue) => valueUpdater(updaterOrValue, rowSelection),
    onExpandedChange: (updaterOrValue) => valueUpdater(updaterOrValue, expanded),
    onGlobalFilterChange: (updaterOrValue) => valueUpdater(updaterOrValue, globalFilter), // Manejar cambios en el filtro global
    state: {
        get sorting() {
            return sorting.value;
        },
        get columnFilters() {
            return columnFilters.value;
        },
        get columnVisibility() {
            return columnVisibility.value;
        },
        get rowSelection() {
            return rowSelection.value;
        },
        get expanded() {
            return expanded.value;
        },
        get globalFilter() {
            // Añadir el filtro global al estado
            return globalFilter.value;
        },
    },
});
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
                    <div class="w-full">
                        <div class="flex items-center gap-2 py-4">
                            <Input
                                class="max-w-sm"
                                placeholder="Buscar en todos los campos..."
                                :model-value="globalFilter as string"
                                @update:model-value="table.setGlobalFilter($event)"
                            />
                            <DropdownMenu>
                                <DropdownMenuTrigger as-child>
                                    <Button variant="outline" class="ml-auto"> Columns <ChevronDown class="ml-2 h-4 w-4" /> </Button>
                                </DropdownMenuTrigger>
                                <DropdownMenuContent align="end">
                                    <DropdownMenuCheckboxItem
                                        v-for="column in table.getAllColumns().filter((column) => column.getCanHide())"
                                        :key="column.id"
                                        class="capitalize"
                                        :model-value="column.getIsVisible()"
                                        @update:model-value="
                                            (value) => {
                                                column.toggleVisibility(!!value);
                                            }
                                        "
                                    >
                                        {{ column.id }}
                                    </DropdownMenuCheckboxItem>
                                </DropdownMenuContent>
                            </DropdownMenu>
                        </div>
                        <div class="rounded-md border">
                            <Table>
                                <TableHeader>
                                    <TableRow v-for="headerGroup in table.getHeaderGroups()" :key="headerGroup.id">
                                        <TableHead
                                            v-for="header in headerGroup.headers"
                                            :key="header.id"
                                            :data-pinned="header.column.getIsPinned()"
                                            :class="
                                                cn(
                                                    { 'bg-background/95 sticky': header.column.getIsPinned() },
                                                    header.column.getIsPinned() === 'left' ? 'left-0' : 'right-0',
                                                )
                                            "
                                        >
                                            <FlexRender
                                                v-if="!header.isPlaceholder"
                                                :render="header.column.columnDef.header"
                                                :props="header.getContext()"
                                            />
                                        </TableHead>
                                    </TableRow>
                                </TableHeader>
                                <TableBody>
                                    <template v-if="table.getRowModel().rows?.length">
                                        <template v-for="row in table.getRowModel().rows" :key="row.id">
                                            <TableRow :data-state="row.getIsSelected() && 'selected'">
                                                <TableCell
                                                    v-for="cell in row.getVisibleCells()"
                                                    :key="cell.id"
                                                    :data-pinned="cell.column.getIsPinned()"
                                                    :class="
                                                        cn(
                                                            { 'bg-background/95 sticky': cell.column.getIsPinned() },
                                                            cell.column.getIsPinned() === 'left' ? 'left-0' : 'right-0',
                                                        )
                                                    "
                                                >
                                                    <FlexRender :render="cell.column.columnDef.cell" :props="cell.getContext()" />
                                                </TableCell>
                                            </TableRow>
                                            <TableRow v-if="row.getIsExpanded()">
                                                <TableCell :colspan="row.getAllCells().length">
                                                    {{ JSON.stringify(row.original) }}
                                                </TableCell>
                                            </TableRow>
                                        </template>
                                    </template>

                                    <TableRow v-else>
                                        <TableCell :colspan="columns.length" class="h-24 text-center"> No existen registros. </TableCell>
                                    </TableRow>
                                </TableBody>
                            </Table>
                        </div>

                        <div class="flex items-center justify-end space-x-2 py-4">
                            <div class="space-x-2">
                                <Button variant="outline" size="sm" :disabled="!table.getCanPreviousPage()" @click="table.previousPage()">
                                    Anterior
                                </Button>
                                <Button variant="outline" size="sm" :disabled="!table.getCanNextPage()" @click="table.nextPage()"> Siguiente </Button>
                            </div>
                        </div>
                    </div>
                </CardContent>
            </Card>
        </ControlLayout>
    </AppLayout>
</template>
