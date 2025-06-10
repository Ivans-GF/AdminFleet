<script setup lang="ts">
import { Dialog, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle, DialogTrigger } from '@/components/ui/dialog';
import { Button } from '@/components/ui/button';

import { ref, watch } from 'vue';
interface Props {
    open: boolean;
    operadorId: number;
}
const props = defineProps<Props>();

const emit = defineEmits(['close', 'save']);

// Watch for changes in the 'open' prop to control the dialog visibility
// Watch for changes in the 'open' prop to control the dialog visibility
const showDialog = ref(props.open);
watch(
    () => props.open,
    (newVal) => {
        showDialog.value = newVal;
    },
);
const handleClose = () => {
    // Emit a 'close' event
    emit('close');
};
</script>
<template>
    <Dialog :open="showDialog" @update:open="handleClose">
        <DialogTrigger> Edit Profile </DialogTrigger>
        <DialogContent>
            <DialogHeader>
                <DialogTitle class="font-bold">Crear Nueva Licencia</DialogTitle>
                <DialogDescription class=""> Ingrese los detalles de la nueva licencia. </DialogDescription>
            </DialogHeader>
            asdasd
            <DialogFooter>
                <Button type="button" variant="outline" @click="handleClose"> Cancelar </Button>
                <Button type="submit" @click=""> Guardar Licencia </Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>
