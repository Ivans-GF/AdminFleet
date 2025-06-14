<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Dialog, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle, DialogTrigger } from '@/components/ui/dialog';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';

import { ref, watch } from 'vue';
interface Props {
    open: boolean;
    operadorId?: number; // This prop seems relevant if the license is tied to an operator
}
const props = defineProps<Props>();
const emit = defineEmits(['close', 'save']);
const showDialog = ref(props.open);

// Variables reactivas para los campos del formulario
const tipoLicencia = ref('');
const archivoLicencia = ref<File | null>(null);
const categoriaLicencia = ref('');
// Cambiamos el tipo de las fechas a Date o undefined para usar con el Calendar
const fechaExpedicion = ref<Date | undefined>(undefined);
const fechaVencimiento = ref<Date | undefined>(undefined);
const fechaVigencia = ref<Date | undefined>(undefined);
const fechaRenovacion = ref<Date | undefined>(undefined);
watch(
    () => props.open,
    (newVal) => {
        showDialog.value = newVal;
    },
);

const handleClose = () => {
    resetForm();
    emit('close');
};
const handleSave = () => {};
const resetForm = () => {};

console.log(props.operadorId);
</script>
<template>
    <Dialog :open="showDialog" @update:open="handleClose">
        <DialogTrigger> Crear Nueva Licencia< </DialogTrigger>
        <DialogContent class="sm:max-w-lg md:max-w-xl">
            <DialogHeader>
                <DialogTitle class="font-bold">Crear Nueva Licencia</DialogTitle>
                <DialogDescription class=""> Ingrese los detalles de la nueva licencia. </DialogDescription>
            </DialogHeader>
            <div class="flex w-full space-x-2">
                <div class="flex-1 space-y-2">
                    <Label for="licencia">PDF de Licencia</Label>
                    <Input id="licencia" type="file" accept=".pdf" />
                    <InputError />
                </div>
            </div>
            <div class="flex w-full space-x-2">
                <div class="flex-1 space-y-2">
                    <Label for="licencia">Fecha vigencia</Label>

                    <InputError />
                </div>
            </div>
            <DialogFooter>
                <Button type="button" variant="outline" @click="handleClose"> Cancelar </Button>
                <Button type="submit" @click="handleSave"> Guardar Licencia </Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>
