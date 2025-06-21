<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Dialog, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle, DialogTrigger } from '@/components/ui/dialog';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import Separator from '@/components/ui/separator/Separator.vue';
import Textarea from '@/components/ui/textarea/Textarea.vue';
import { Licencia } from '@/types';
import { useForm } from '@inertiajs/vue3';
import { LoaderCircle, SaveIcon } from 'lucide-vue-next';
import { ref } from 'vue';
interface Props {
    open: boolean;
    licencia?: Licencia;
    operadorId?: number;
}
const props = defineProps<Props>();
const emit = defineEmits(['close', 'save']);
const showDialog = ref(props.open);
const handleClose = () => {
    form.reset();
    emit('close');
};

const form = useForm({
    idoperador: props.operadorId,
    licencia: null as File | null,
    vigencia: '',
    categorias: [] as string[],
    comentario: '',
});

// This is the crucial part for file handling!
const handleFileChange = (event: Event) => {
    const target = event.target as HTMLInputElement;
    if (target.files && target.files.length > 0) {
        form.licencia = target.files[0]; // Assigns the actual File object
    } else {
        form.licencia = null;
    }
};

const handleSubmit = () => {
    console.log('FORM DATA BEING SENT:', form.data());
    form.post(route('operadores.storelicencia'), {
        preserveScroll: true,
        onSuccess: () => {
            emit('save');
            handleClose();
        },
        forceFormData: true, // This is essential for sending files and arrays correctly via FormData
    });
};

console.log('Operador ID:', props.operadorId); // This console.log is fine
</script>
<template>
    <Dialog :open="showDialog" @update:open="handleClose">
        <DialogTrigger> Crear Nueva Licencia< </DialogTrigger>
        <DialogContent class="sm:max-w-lg md:max-w-xl">
            <DialogHeader>
                <DialogTitle class="font-bold">Crear Nueva Licencia</DialogTitle>
                <DialogDescription class=""> Ingrese los detalles de la nueva licencia. </DialogDescription>
            </DialogHeader>
            <form @submit.prevent="handleSubmit" class="space-y-2">
                <div class="flex w-full space-x-2">
                    <div class="flex-2 space-y-2">
                        <Label for="licencia">PDF de Licencia</Label>
                        <Input id="licencia" type="file" accept=".pdf" @change="handleFileChange" />
                        <InputError :message="form.errors.licencia" />
                    </div>
                    <div class="basis-1xs space-y-2">
                        <Label for="vigencia">Fecha vigencia</Label>
                        <Input id="vigencia" type="date" v-model="form.vigencia" />
                        <InputError :message="form.errors.vigencia" />
                    </div>
                </div>
                <Separator />
                <div class="flex w-full space-x-2">
                    <div class="flex-1 space-y-2">
                        <Label for="comentario">Comentario</Label>
                        <Textarea id="comentario" v-model="form.comentario" :disabled="form.processing" />
                        <InputError :message="form.errors.comentario" />
                    </div>
                </div>
                <DialogFooter>
                    <Button type="button" variant="outline" @click="handleClose">Cancelar</Button>
                    <Button type="submit" :disabled="form.processing">
                        <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                        <SaveIcon v-else class="mr-2 h-4 w-4" /> {{ form.processing ? 'Guardando...' : 'Guardar' }}
                    </Button>
                </DialogFooter>
            </form>
        </DialogContent>
    </Dialog>
</template>
