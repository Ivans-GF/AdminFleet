<script setup lang="ts">
import HeadingSmall from '@/components/HeadingSmall.vue';
import Button from '@/components/ui/button/Button.vue';
import Card from '@/components/ui/card/Card.vue';
import CardContent from '@/components/ui/card/CardContent.vue';
import CardHeader from '@/components/ui/card/CardHeader.vue';
import CardTitle from '@/components/ui/card/CardTitle.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import ControlLayout from '@/pages/ControlFlota/Layout.vue';
import { type BreadcrumbItem, type Operador } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import { CirclePlus, UndoDot } from 'lucide-vue-next';
import { ref } from 'vue';
import DialogCreateLicencia from './components/DialogCreateLicencia.vue';

interface Props {
    operador?: Operador;
}

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

const props = defineProps<Props>();
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
                            <Button size="sm" @click="handleOpenDialog"> <CirclePlus class="mr-2 h-4 w-4" />Nuevo operador </Button>
                        </div>
                    </CardTitle>
                </CardHeader>
                <CardContent> </CardContent>
            </Card>
        </ControlLayout>
    </AppLayout>
    <DialogCreateLicencia v-if="showDialogicencia" :open="showDialogicencia" :operadorId="props.operador?.id" @close="cancelModaDialog" />
</template>
