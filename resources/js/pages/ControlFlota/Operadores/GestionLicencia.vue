<script setup lang="ts">
import HeadingSmall from '@/components/HeadingSmall.vue';
import MyDataTable from '@/components/mycomponents/Datatable/MyDataTable.vue';
import Button from '@/components/ui/button/Button.vue';
import Card from '@/components/ui/card/Card.vue';
import CardContent from '@/components/ui/card/CardContent.vue';
import CardHeader from '@/components/ui/card/CardHeader.vue';
import CardTitle from '@/components/ui/card/CardTitle.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import ControlLayout from '@/pages/ControlFlota/Layout.vue';
import { type BreadcrumbItem, type Licencia, type Operador } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import { createColumnHelper, type ColumnDef } from '@tanstack/vue-table'; // Make sure ColumnDef is imported here too!
import { ChevronsUpDown, CirclePlus, UndoDot } from 'lucide-vue-next';
import { h, ref } from 'vue';
import DialogCreateLicencia from './components/DialogCreateLicencia.vue';

const props = defineProps<{
    operador?: Operador;
    licencias?: Licencia[];
}>();

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

const data = props.licencias || [];
const columnHelper = createColumnHelper<Operador>();

const showDialogicencia = ref(false);

const handleOpenDialog = () => {
    showDialogicencia.value = true;
};
const cancelModaDialog = () => {
    showDialogicencia.value = false;
};

const columns = [
    //Campo Categoria
    columnHelper.accessor((row) => `${row.categoria}`.trim(), {
        id: 'Categoria',
        header: ({ column }) => {
            return h(
                Button,
                {
                    variant: 'ghost',
                    onClick: () => column.toggleSorting(column.getIsSorted() === 'asc'),
                },
                () => ['Categoria', h(ChevronsUpDown, { class: 'ml-2 h-4 w-4' })],
            );
        },
        cell: (info) => info.getValue(),
        enableSorting: true,
        enableHiding: true,
        enableColumnFilter: true, // Crucial: Enable filtering for this column
    }),
    //Campo fecha vigencia
    columnHelper.accessor((row) => `${row.fechavigencia}`.trim(), {
        id: 'fechavigencia',
        header: ({ column }) => {
            return h(
                Button,
                {
                    variant: 'ghost',
                    onClick: () => column.toggleSorting(column.getIsSorted() === 'asc'),
                },
                () => ['Fecha Vigencia', h(ChevronsUpDown, { class: 'ml-2 h-4 w-4' })],
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
        <Head title="Control Flota - Gestión de licencia" />
        <ControlLayout>
            <HeadingSmall title="Gestión de licencia" />
            <Card>
                <CardHeader>
                    <CardTitle>
                        <div class="flex flex-row justify-end space-x-2">
                            <Button as-child variant="outline" size="sm">
                                <Link :href="route('operadores.index')"> <UndoDot class="mr-2 h-4 w-4" />Regresar</Link>
                            </Button>
                            <Button size="sm" @click="handleOpenDialog"> <CirclePlus class="mr-2 h-4 w-4" />Nueva licencia </Button>
                        </div>
                    </CardTitle>
                </CardHeader>
                <CardContent>
                    <MyDataTable :columns="columns" :data="data" :filtro="false" :optionestable="false" />
                </CardContent>
            </Card>
        </ControlLayout>
    </AppLayout>
    <DialogCreateLicencia v-if="showDialogicencia" :open="showDialogicencia" :operadorId="props.operador?.id" @close="cancelModaDialog" />
</template>
