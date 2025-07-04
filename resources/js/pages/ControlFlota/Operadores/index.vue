<script setup lang="ts">
import HeadingSmall from '@/components/HeadingSmall.vue';
import { Badge } from '@/components/ui/badge';
import Button from '@/components/ui/button/Button.vue';
import { Card, CardContent, CardTitle } from '@/components/ui/card';
import CardHeader from '@/components/ui/card/CardHeader.vue';
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import AppLayout from '@/layouts/AppLayout.vue';
import ControlLayout from '@/pages/ControlFlota/Layout.vue';
import { type BreadcrumbItem, type Operador, type SharedData } from '@/types';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { Camera, CirclePlus, ClipboardPlus, EllipsisVertical, IdCard, Menu, UserPen } from 'lucide-vue-next';

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
                                    <TableHead class="flex items-center justify-center">Licencia</TableHead>
                                    <TableHead>Teléfono</TableHead>
                                    <TableHead class="flex items-center justify-center">Estado</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                <TableRow v-for="operador in props.operadores" :key="operador.id">
                                    <TableCell>
                                        <DropdownMenu>
                                            <DropdownMenuTrigger>
                                                <Button size="sm" variant="ghost">
                                                    <EllipsisVertical />
                                                </Button>
                                            </DropdownMenuTrigger>
                                            <DropdownMenuContent>
                                                <DropdownMenuItem size="sm" value="bottom">
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
                                        <div class="flex flex-row space-x-2">
                                            <a
                                                v-if="operador.archivo"
                                                title="Indicador de licencia - click para ver licencia del operador"
                                                :href="`/storage/${operador.archivo}`"
                                                target="_blank"
                                            >
                                                <IdCard
                                                    :class="{
                                                        'text-red-400':
                                                            operador.dias_restanteslicencia !== null && operador.dias_restanteslicencia <= 0,
                                                        'text-yellow-400':
                                                            operador.dias_restanteslicencia !== null &&
                                                            operador.dias_restanteslicencia > 0 &&
                                                            operador.dias_restanteslicencia <= 30, // Yellow for expiring soon (1-30 days)
                                                        'text-green-400':
                                                            operador.dias_restanteslicencia !== null && operador.dias_restanteslicencia > 30,
                                                    }"
                                            /></a>
                                            <span v-else title="Sin registro de licencia para este operador">
                                                <IdCard class="" />
                                            </span>
                                            <ClipboardPlus
                                                :class="{
                                                    'text-red-400': operador.medico === null,
                                                }"
                                            />
                                            <Camera />
                                        </div>
                                    </TableCell>
                                    <TableCell>{{ operador.nombre }} {{ operador.apellido }}</TableCell>
                                    <TableCell class="d-flex align-center justify-center text-center">
                                        {{ operador.categoria ?? 'N/D' }}
                                    </TableCell>
                                    <TableCell>{{ operador.telefono }}</TableCell>
                                    <TableCell class="d-flex align-center justify-center text-center">
                                        <Badge
                                            :class="{
                                                'bg-red-400 text-white': operador.estado === 0,
                                                'bg-green-400 text-white': operador.estado === 1,
                                            }"
                                        >
                                            {{ operador.estado === 0 ? 'Inactivo' : 'Activo' }}
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
