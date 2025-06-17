<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import Checkbox from '@/components/ui/checkbox/Checkbox.vue';
import { Dialog, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle, DialogTrigger } from '@/components/ui/dialog';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
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
    licencia: null as File | null, // Correct type for file upload
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
    console.log('Aqui paso el FORM:', form.data()); // Still useful for debugging
    // form.post(route('licencias.store'), {
    // Assuming 'licencias.store' is your route name for saving
    //   onSuccess: () => {
    //       emit('save'); // Emit a 'save' event on successful submission
    //      handleClose(); // Close the dialog after saving
    //   },
    //   forceFormData: true, // Crucial for file uploads with Inertia
    //});
};
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
                <div class="flex flex-wrap items-center justify-center space-x-5">
                    <Label>Tipo de Licencia</Label>
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center space-x-2">
                            <Checkbox id="type-a" value="A" v-model:checked="form.categorias" />
                            <Label for="type-a">Tipo A</Label>
                        </div>
                        <div class="flex items-center space-x-2">
                            <Checkbox id="type-b" value="B" v-model:checked="form.categorias" />
                            <Label for="type-b">Tipo B</Label>
                        </div>
                        <div class="flex items-center space-x-2">
                            <Checkbox id="type-c" value="C" v-model:checked="form.categorias" />
                            <Label for="type-c">Tipo C</Label>
                        </div>
                        <div class="flex items-center space-x-2">
                            <Checkbox id="type-e" value="E" v-model:checked="form.categorias" />
                            <Label for="type-e">Tipo E</Label>
                        </div>
                    </div>
                    <InputError :message="form.errors.categorias" />
                </div>
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
