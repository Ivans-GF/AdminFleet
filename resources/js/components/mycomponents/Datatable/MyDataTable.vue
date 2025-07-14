<script setup lang="ts">
import { cn } from '@/lib/utils';
import {
    ColumnDef,
    ColumnFiltersState,
    ExpandedState,
    FlexRender,
    getCoreRowModel,
    getExpandedRowModel,
    getFilteredRowModel,
    getPaginationRowModel,
    getSortedRowModel,
    SortingState,
    Table,
    useVueTable,
    VisibilityState,
} from '@tanstack/vue-table';
import { ref, toRefs } from 'vue';
import { valueUpdater } from './utils';

import Button from '@/components/ui/button/Button.vue';
import DropdownMenu from '@/components/ui/dropdown-menu/DropdownMenu.vue';
import DropdownMenuCheckboxItem from '@/components/ui/dropdown-menu/DropdownMenuCheckboxItem.vue';
import DropdownMenuContent from '@/components/ui/dropdown-menu/DropdownMenuContent.vue';
import DropdownMenuTrigger from '@/components/ui/dropdown-menu/DropdownMenuTrigger.vue';
import Input from '@/components/ui/input/Input.vue';
import TableComponent from '@/components/ui/table/Table.vue'; // Renamed to avoid conflict
import TableBody from '@/components/ui/table/TableBody.vue';
import TableCell from '@/components/ui/table/TableCell.vue';
import TableHead from '@/components/ui/table/TableHead.vue';
import TableHeader from '@/components/ui/table/TableHeader.vue';
import TableRow from '@/components/ui/table/TableRow.vue';
import { ChevronDown, Sheet } from 'lucide-vue-next';

interface DataTableProps<TData> {
    columns: ColumnDef<TData>[];
    data: TData[];
}

const props = defineProps<DataTableProps<any>>();
const { data } = toRefs(props);

const sorting = ref<SortingState>([]);
const columnFilters = ref<ColumnFiltersState>([]);
const columnVisibility = ref<VisibilityState>({});
const rowSelection = ref({});
const expanded = ref<ExpandedState>({});
const globalFilter = ref('');
const pageSize = ref(10); // Added for pagination size

const table: Table<any> = useVueTable({
    get data() {
        return data.value;
    },
    columns: props.columns,
    getCoreRowModel: getCoreRowModel(),
    getPaginationRowModel: getPaginationRowModel(),
    getSortedRowModel: getSortedRowModel(),
    getFilteredRowModel: getFilteredRowModel(),
    getExpandedRowModel: getExpandedRowModel(),
    onSortingChange: (updaterOrValue) => valueUpdater(updaterOrValue, sorting),
    onColumnFiltersChange: (updaterOrValue) => valueUpdater(updaterOrValue, columnFilters),
    onColumnVisibilityChange: (updaterOrValue) => valueUpdater(updaterOrValue, columnVisibility),
    onRowSelectionChange: (updaterOrValue) => valueUpdater(updaterOrValue, rowSelection),
    onExpandedChange: (updaterOrValue) => valueUpdater(updaterOrValue, expanded),
    onGlobalFilterChange: (updaterOrValue) => valueUpdater(updaterOrValue, globalFilter),
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
            return globalFilter.value;
        },
        // --- FIX START ---
        get pagination() {
            return {
                pageIndex: 0, // Provide an initial page index (0-based)
                pageSize: pageSize.value,
            };
        },
        // --- FIX END ---
    },
    // This correctly updates your local pageSize ref when pagination state changes
    onPaginationChange: (updaterOrValue) => {
        const newState = typeof updaterOrValue === 'function' ? updaterOrValue(table.getState().pagination) : updaterOrValue;
        // Ensure you only update pageSize if it's different to prevent unnecessary reactivity
        if (newState.pageSize !== pageSize.value) {
            pageSize.value = newState.pageSize;
        }
    },
});

// --- Función para exportar a CSV ---
const exportToCsv = () => {
    const rows = table.getFilteredRowModel().rows; // Obtiene todas las filas filtradas
    const headers = table
        .getAllColumns()
        .filter((column) => column.getIsVisible() && column.columnDef.header) // Solo columnas visibles con encabezado
        .map((column) => (typeof column.columnDef.header === 'string' ? column.columnDef.header : column.id)); // Usar string del header o id

    // Crea el encabezado excelß
    let csvContent = headers.join(',') + '\n';

    // Agrega las filas de datos
    rows.forEach((row) => {
        const rowData = headers
            .map((header) => {
                const columnId = table.getAllColumns().find((col) => {
                    const headerText = typeof col.columnDef.header === 'string' ? col.columnDef.header : col.id;
                    return headerText === header;
                })?.id;

                if (columnId) {
                    // Asegúrate de que el valor sea un string y escapa las comas y comillas
                    const cellValue = row.getValue(columnId) ?? '';
                    return `"${String(cellValue).replace(/"/g, '""')}"`;
                }
                return '';
            })
            .join(',');
        csvContent += rowData + '\n';
    });

    const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
    const url = URL.createObjectURL(blob);
    const link = document.createElement('a');
    link.setAttribute('href', url);
    link.setAttribute('download', 'datos_tabla.csv');
    link.click();
    URL.revokeObjectURL(url); // Libera la URL del objeto
};
</script>

<template>
    <div class="w-full">
        <div class="flex items-center gap-2 py-4">
            <Input
                class="max-w-sm"
                placeholder="Filtro..."
                :model-value="globalFilter as string"
                @update:model-value="table.setGlobalFilter($event)"
            />
            <div class="ml-auto flex items-center gap-2">
                <Button variant="outline" @click="exportToCsv"> <Sheet class="mr-2 h-4 w-4" /> Exportar - Excel </Button>
                <DropdownMenu>
                    <DropdownMenuTrigger as-child>
                        <Button variant="outline" class="ml-auto"> Columnas <ChevronDown class="ml-2 h-4 w-4" /> </Button>
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
        </div>
        <div class="rounded-md border">
            <TableComponent>
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
                            <FlexRender v-if="!header.isPlaceholder" :render="header.column.columnDef.header" :props="header.getContext()" />
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
                        <TableCell :colspan="props.columns.length" class="h-24 text-center"> No existen registros. </TableCell>
                    </TableRow>
                </TableBody>
            </TableComponent>
        </div>

        <div class="flex items-center justify-end space-x-2 py-4">
            <div class="text-muted-foreground flex flex-1 items-center gap-4 text-sm">
                Mostrando {{ table.getRowModel().rows.length }} de {{ table.getRowCount() }} registro(s).

                <div class="flex items-center space-x-2">
                    <p class="text-sm font-medium">Registros por página</p>
                    <DropdownMenu>
                        <DropdownMenuTrigger as-child>
                            <Button variant="outline" class="h-8 w-16 px-2">
                                {{ pageSize === Infinity ? 'Todo' : pageSize }} <ChevronDown class="ml-2 h-4 w-4" />
                            </Button>
                        </DropdownMenuTrigger>
                        <DropdownMenuContent align="end">
                            <DropdownMenuCheckboxItem :model-value="pageSize === 10" @update:model-value="table.setPageSize(10)">
                                10
                            </DropdownMenuCheckboxItem>
                            <DropdownMenuCheckboxItem :model-value="pageSize === 30" @update:model-value="table.setPageSize(30)">
                                30
                            </DropdownMenuCheckboxItem>
                            <DropdownMenuCheckboxItem
                                :model-value="pageSize === Infinity"
                                @update:model-value="table.setPageSize(table.getRowCount())"
                            >
                                Todo
                            </DropdownMenuCheckboxItem>
                        </DropdownMenuContent>
                    </DropdownMenu>
                </div>
            </div>

            <div class="flex items-center space-x-2">
                <div class="text-muted-foreground mr-4 flex-1 text-sm font-medium">
                    Página {{ table.getState().pagination.pageIndex + 1 }} de {{ table.getPageCount() }}
                </div>

                <Button variant="outline" size="sm" :disabled="!table.getCanPreviousPage()" @click="table.previousPage()"> Anterior </Button>
                <Button variant="outline" size="sm" :disabled="!table.getCanNextPage()" @click="table.nextPage()"> Siguiente </Button>
            </div>
        </div>
    </div>
</template>
