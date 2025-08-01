<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Dialog, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle, DialogTrigger } from '@/components/ui/dialog';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import Select from '@/components/ui/select/Select.vue';
import SelectContent from '@/components/ui/select/SelectContent.vue';
import SelectGroup from '@/components/ui/select/SelectGroup.vue';
import SelectItem from '@/components/ui/select/SelectItem.vue';
import SelectTrigger from '@/components/ui/select/SelectTrigger.vue';
import SelectValue from '@/components/ui/select/SelectValue.vue';
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
    operador_id: props.operadorId,
    nolicencia: '',
    archivo: null as File | null,
    fechavigencia: '',
    categoria: '',
    comentario: '',
});

// This is the crucial part for file handling!
const handleFileChange = (event: Event) => {
    const target = event.target as HTMLInputElement;
    if (target.files && target.files.length > 0) {
        form.archivo = target.files[0]; // Assigns the actual File object
    } else {
        form.archivo = null;
    }
};

const handleSubmit = () => {
    form.post(route('operadores.storelicencia'), {
        preserveScroll: true,
        onSuccess: () => {
            emit('save');
            handleClose();
        },
        forceFormData: true,
    });
};
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
                    <div class="basis-1xs space-y-2">
                        <Label for="fechavigencia">Fecha vigencia</Label>
                        <Input id="fechavigencia" type="date" v-model="form.fechavigencia" />
                        <InputError :message="form.errors.fechavigencia" />
                    </div>
                    <div class="flex-2 space-y-2">
                        <Label>Categoría de licencia</Label>
                        <Select v-model="form.categoria">
                            <SelectTrigger class="w-[100%]">
                                <SelectValue placeholder="Categorías" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectGroup>
                                    <SelectItem value="B" title="B) CARGA">B</SelectItem>
                                    <SelectItem value="E" title="E) CARGA TRACTOCAMIONES DOBLEMENTE ARTICULADOS TSR/TSS">E</SelectItem>
                                    <SelectItem value="BE" title="B) CARGA &#10;E) CARGA TRACTOCAMIONES DOBLEMENTE ARTICULADOS TSR/TSS"
                                        >BE</SelectItem
                                    >
                                </SelectGroup>
                            </SelectContent>
                        </Select>
                        <InputError :message="form.errors.categoria" />
                    </div>
                </div>
                <div class="flex w-full space-x-2">
                    <div class="flex-2 space-y-2">
                        <Label for="archivo">PDF de Licencia</Label>
                        <Input id="archivo" type="file" accept=".pdf" @change="handleFileChange" />
                        <InputError :message="form.errors.archivo" />
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
