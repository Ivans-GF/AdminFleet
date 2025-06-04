<script setup lang="ts">
import HeadingSmall from '@/components/HeadingSmall.vue';
import { Badge } from '@/components/ui/badge';
import Button from '@/components/ui/button/Button.vue';
import { Card, CardContent, CardTitle } from '@/components/ui/card';
import CardHeader from '@/components/ui/card/CardHeader.vue';
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
import { Camera, CirclePlus, ClipboardPlus, EllipsisVertical, IdCard, Menu, UserPen } from 'lucide-vue-next';

interface Operador {
    id: number;
    nombre: string;
    apellido: string;
    estatus: number;
    estado: number;
    telefono: string;
}
const props = defineProps<{
    operadores: Operador[];
}>();

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
                            <DropdownMenu>
                                <DropdownMenuTrigger>
                                    <Button size="sm" variant="secondary"><Menu class="mr-2 h-4 w-4" />Opciones</Button>
                                </DropdownMenuTrigger>
                                <DropdownMenuContent>
                                    <DropdownMenuLabel>Opciones</DropdownMenuLabel>
                                    <DropdownMenuSeparator />
                                    <DropdownMenuItem><Menu class="mr-2 h-4 w-4" />Documentación</DropdownMenuItem>
                                </DropdownMenuContent>
                            </DropdownMenu>
                            <Button as-child size="sm">
                                <Link :href="route('operadores.create')"> <CirclePlus class="mr-2 h-4 w-4" />Nuevo operador</Link>
                            </Button>
                        </div>
                    </CardTitle>
                </CardHeader>
                <CardContent>
                    <div class="flex h-full flex-1 flex-col gap-2 rounded-xl p-2">
                        <Table>
                            <TableHeader>
                                <TableRow>
                                    <TableHead></TableHead>
                                    <TableHead>Indicadores</TableHead>
                                    <TableHead>Nombre operador</TableHead>
                                    <TableHead>Teléfono</TableHead>
                                    <TableHead class="flex items-center justify-center">Estatus</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                <TableRow v-for="operador in props.operadores" :key="operador.id">
                                    <TableCell>
                                        <DropdownMenu>
                                            <DropdownMenuTrigger>
                                                <Button size="lg" variant="ghost">
                                                    <EllipsisVertical />
                                                </Button>
                                            </DropdownMenuTrigger>
                                            <DropdownMenuContent>
                                                <DropdownMenuItem value="bottom">
                                                    <Link :href="route('operadores.edit', operador.id)" class="flex items-center">
                                                        <UserPen class="mr-2 h-4 w-4" /> Modificar datos
                                                    </Link>
                                                </DropdownMenuItem>
                                                <DropdownMenuItem value="bottom">
                                                    <Link :href="route('operadores.gestionlicencia', operador.id)" class="flex items-center">
                                                        <Camera class="mr-2 h-4 w-4" />Gestión foto
                                                    </Link>
                                                </DropdownMenuItem>
                                                <DropdownMenuSeparator />
                                                <DropdownMenuItem value="bottom">
                                                    <Link :href="route('operadores.gestionlicencia', operador.id)" class="flex items-center">
                                                        <IdCard class="mr-2 h-4 w-4" />Gestión licencia
                                                    </Link>
                                                </DropdownMenuItem>
                                                <DropdownMenuItem><ClipboardPlus class="mr-2 h-4 w-4" />Gestión acto medico</DropdownMenuItem>
                                            </DropdownMenuContent>
                                        </DropdownMenu>
                                    </TableCell>
                                    <TableCell>
                                        <div class="flex flex-row space-x-2"><Camera /><IdCard /> <ClipboardPlus /></div>
                                    </TableCell>
                                    <TableCell>{{ operador.nombre }} {{ operador.apellido }}</TableCell>
                                    <TableCell>{{ operador.telefono }}</TableCell>
                                    <TableCell class="d-flex align-center justify-center text-center">
                                        <Badge
                                            :class="{
                                                'bg-red-400 text-white': operador.estado === 0,
                                                'bg-green-400 text-white': operador.estado === 1,
                                            }"
                                        >
                                            {{ operador.estatus === 0 ? 'Inactivo' : 'Activo' }}
                                        </Badge>
                                    </TableCell>
                                </TableRow>
                            </TableBody>
                        </Table>
                    </div>
                </CardContent>
            </Card>
        </ControlLayout>
    </AppLayout>
</template>
