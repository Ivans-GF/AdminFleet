<script setup lang="ts">
import HeadingSmall from '@/components/HeadingSmall.vue';
import MyDataTable from '@/components/mycomponents/Datatable/MyDataTable.vue';
import Button from '@/components/ui/button/Button.vue';
import Card from '@/components/ui/card/Card.vue';
import CardContent from '@/components/ui/card/CardContent.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import ControlLayout from '@/pages/ControlFlota/Layout.vue';
import { type BreadcrumbItem, type Licencia, type Operador } from '@/types';
import { Head, Link, router } from '@inertiajs/vue3';
import { createColumnHelper, type ColumnDef } from '@tanstack/vue-table';
import { format } from 'date-fns/format';

import CardHeader from '@/components/ui/card/CardHeader.vue';
import CardTitle from '@/components/ui/card/CardTitle.vue';
import { es } from 'date-fns/locale';
import { ArrowDown, ArrowUp, ChevronsUpDown, CirclePlus, Trash2, UndoDot } from 'lucide-vue-next'; // ✨ Removed ArrowDown, ArrowUp, ChevronsUpDown as they are no longer needed for sorting UI
import Swal from 'sweetalert2';
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

const handleDeleteLicencia = (licenciaId: number) => {
    Swal.fire({
        title: '¿Estás seguro?',
        text: '¡No podrás revertir esto!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626', // Tailwind's red-600
        cancelButtonColor: '#6b7280', // Tailwind's gray-500
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
        reverseButtons: true, // Puts cancel on the left
    }).then((result) => {
        if (result.isConfirmed) {
            router.delete(route('licencia.delete', { idlicencia: licenciaId }), {
                preserveScroll: true,
                onSuccess: () => {
                    Swal.fire('¡Eliminado!', 'La licencia ha sido eliminada con éxito.', 'success');
                },
                onError: (errors) => {
                    console.error('Error al eliminar la licencia:', errors);
                    Swal.fire('Error', 'Hubo un problema al eliminar la licencia. Por favor, inténtalo de nuevo.', 'error');
                },
            });
        }
    });
};

const columns = [
    // Campo Categoria
    columnHelper.accessor((row) => `${row.categoria}`.trim(), {
        id: 'Categoria',
        header: ({ column }) => {
            return h(
                Button,
                {
                    variant: 'ghost',
                    class: 'w-full justify-center text-center font-semibold',
                },
                () => ['Categoria'],
            );
        },
        cell: (info) => h('div', { class: 'text-center' }, info.getValue()),
        enableSorting: false,
        enableHiding: false,
        enableColumnFilter: false,
    }),
    // Campo fecha vigencia -
    columnHelper.accessor((row) => `${row.fechavigencia}`.trim(), {
        id: 'fechavigencia',
        header: ({ column }) => {
            return h(
                Button,
                {
                    variant: 'ghost',
                    class: 'w-full justify-center text-center font-semibold',
                    // ✨ Re-added onClick handler to allow sorting
                    onClick: () => column.toggleSorting(column.getIsSorted() === 'asc'),
                },
                () => [
                    'Fecha Vigencia',
                    // ✨ Re-added sorting icons based on current sort state
                    column.getIsSorted() === 'asc'
                        ? h(ArrowUp, { class: 'ml-2 h-4 w-4' }) // Ascending icon
                        : column.getIsSorted() === 'desc'
                          ? h(ArrowDown, { class: 'ml-2 h-4 w-4' }) // Descending icon
                          : h(ChevronsUpDown, { class: 'ml-2 h-4 w-4 text-muted-foreground' }), // Default unsorted icon
                ],
            );
        },
        cell: (info) => h('div', { class: 'text-center' }, info.getValue()),
        enableSorting: true, // This should already be true if you followed the last step
        enableHiding: false,
        enableColumnFilter: false,
    }),
    // Campo fecha registro
    columnHelper.accessor((row) => row.created_at, {
        id: 'fecharegistro',
        header: ({ column }) => {
            return h(
                Button,
                {
                    variant: 'ghost',
                    class: 'w-full justify-center text-center font-semibold', // ✨ Changed to justify-center and text-center for consistency
                },
                () => ['Fecha registro'],
            );
        },
        // ✨ MODIFIED: Centering the cell content
        cell: (info) => {
            const dateValue = info.getValue(); // Get the value (could be string, Date, null, undefined)
            let formattedDate: string = ''; // Explicitly type as string
            if (dateValue) {
                try {
                    const dateObject = typeof dateValue === 'string' ? new Date(dateValue) : dateValue;
                    formattedDate = format(dateObject, 'dd/MM/yyyy HH:mm', { locale: es });
                } catch (error) {
                    console.error('Error formatting date:', error, dateValue);
                    formattedDate = String(dateValue); // Fallback to string conversion if date parsing fails
                }
            }
            return h('div', { class: 'text-center' }, formattedDate); // Wrap in div with text-center
        },
        enableSorting: false,
        enableHiding: false,
        enableColumnFilter: false,
    }),
    ,
    // Actions Column for Delete Button
    columnHelper.display({
        id: 'acciones',
        header: () => h('div', { class: 'text-center font-semibold' }, 'Acciones'),
        cell: (props) =>
            h(
                Button,
                {
                    variant: 'destructive',
                    size: 'sm',
                    class: 'mx-auto',
                    onClick: () => handleDeleteLicencia(props.row.original.id),
                },
                () => h(Trash2, { class: 'h-4 w-4' }),
            ),
        enableSorting: false,
        enableHiding: false,
        enableColumnFilter: false,
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
