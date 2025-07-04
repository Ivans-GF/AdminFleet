<script setup lang="ts">
import HeadingSmall from '@/components/HeadingSmall.vue';
import Button from '@/components/ui/button/Button.vue';
import Card from '@/components/ui/card/Card.vue';
import CardContent from '@/components/ui/card/CardContent.vue';
import CardHeader from '@/components/ui/card/CardHeader.vue';
import CardTitle from '@/components/ui/card/CardTitle.vue';
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import AppLayout from '@/layouts/AppLayout.vue';
import ControlLayout from '@/pages/ControlFlota/Layout.vue';
import { type BreadcrumbItem, type Licencia, type Operador, type SharedData } from '@/types';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { CirclePlus, ClipboardPlus, EllipsisVertical, UndoDot, UserPen } from 'lucide-vue-next';
import { ref } from 'vue';
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

const showDialogicencia = ref(false);

const handleOpenDialog = () => {
    showDialogicencia.value = true;
};
const cancelModaDialog = () => {
    showDialogicencia.value = false;
};
const page = usePage<SharedData>();
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
                    <div class="flex h-full flex-1 flex-col gap-2 rounded-xl p-2">
                        <Table>
                            <TableHeader>
                                <TableRow>
                                    <TableHead></TableHead>
                                    <TableHead>No. Licencia</TableHead>
                                    <TableHead>Categoria</TableHead>
                                    <TableHead>Vigencia</TableHead>
                                    <TableHead>Fecha registro</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                <TableRow v-for="licencia in props.licencias" :key="licencia.id">
                                    <TableCell>
                                        <DropdownMenu>
                                            <DropdownMenuTrigger>
                                                <Button size="sm" variant="ghost">
                                                    <EllipsisVertical />
                                                </Button>
                                            </DropdownMenuTrigger>
                                            <DropdownMenuContent>
                                                <DropdownMenuItem size="sm" value="bottom">
                                                    <Link :href="route('operadores.edit', licencia.id)" class="flex items-center">
                                                        <UserPen class="mr-2 h-4 w-4" /> Modificar datos
                                                    </Link>
                                                </DropdownMenuItem>

                                                <DropdownMenuItem><ClipboardPlus class="mr-2 h-4 w-4" />Gestión acto medico</DropdownMenuItem>
                                            </DropdownMenuContent>
                                        </DropdownMenu>
                                    </TableCell>
                                    <TableCell>{{ licencia.nolicencia }}</TableCell>
                                    <TableCell>{{ licencia.categoria }}</TableCell>
                                    <TableCell>{{ licencia.fechavigencia }}</TableCell>
                                    <TableCell>{{ licencia.fechavigencia }}</TableCell>
                                </TableRow>
                            </TableBody>
                        </Table>
                    </div>
                </CardContent>
            </Card>
        </ControlLayout>
    </AppLayout>
    <DialogCreateLicencia v-if="showDialogicencia" :open="showDialogicencia" :operadorId="props.operador?.id" @close="cancelModaDialog" />
</template>
