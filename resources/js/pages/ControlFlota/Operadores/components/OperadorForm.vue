<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import Separator from '@/components/ui/separator/Separator.vue';
import Textarea from '@/components/ui/textarea/Textarea.vue';
import { type Operador } from '@/types';
import { Link, useForm } from '@inertiajs/vue3';
import { LoaderCircle, SaveIcon, UndoDot } from 'lucide-vue-next';
import { vMaska } from 'maska/vue';
import { computed } from 'vue';

type OperadorForm = 'create' | 'edit';

interface Props {
    operador?: Operador;
    mode: OperadorForm;
}

const props = withDefaults(defineProps<Props>(), {
    operador: undefined,
    mode: 'create',
});

const buttonText = computed(() => (props.mode === 'create' ? 'Guardar ' : 'Actualizar Tarea'));

const form = useForm({
    curp: props.operador?.curp || '',
    rfc: props.operador?.rfc || '',
    nss: props.operador?.nss || '',
    nombre: props.operador?.nombre || '',
    apellido: props.operador?.apellido || '',
    telefono: props.operador?.telefono || '',
    nolicencia: props.operador?.nolicencia || '',
    noexpediente: props.operador?.noexpediente || '',
    domicilio: props.operador?.domicilio || '',
    nota: props.operador?.nota || '',
});

const handleSubmit = () => {
    if (props.mode === 'create') {
        form.post(route('operadores.store'), {
            preserveScroll: true,
        });
    } else if (props.operador) {
        form.patch(route('operadores.update', { operador: props.operador.id }));
    }
};
</script>
<template>
    <Card>
        <CardHeader>
            <CardTitle>
                <div class="flex flex-row justify-end space-x-2">
                    <Button as-child variant="outline">
                        <Link :href="route('operadores.index')"> <UndoDot class="mr-2 h-4 w-4" />Regresar</Link>
                    </Button>
                </div>
            </CardTitle>
        </CardHeader>
        <form @submit.prevent="handleSubmit" class="space-y-2">
            <CardContent class="space-y-2">
                <div class="flex w-full justify-end">
                    <div class="ml-auto flex flex-row space-x-2">
                        <div class="basis-2xs space-y-2">
                            <Label for="curp">CURP</Label>
                            <Input id="curp" v-model="form.curp" :disabled="form.processing" />
                            <InputError :message="form.errors.curp" />
                        </div>
                        <div class="basis-1xs space-y-2">
                            <Label for="rfc">RFC</Label>
                            <Input id="rfc" v-model="form.rfc" :disabled="form.processing" />
                            <InputError :message="form.errors.rfc" />
                        </div>
                    </div>
                </div>
                <div class="flex w-full space-x-2">
                    <div class="flex-1 space-y-2">
                        <Label for="nombre">Nombre</Label>
                        <Input id="nombre" v-model="form.nombre" :disabled="form.processing" />
                        <InputError :message="form.errors.nombre" />
                    </div>
                    <div class="flex-1 space-y-2">
                        <Label for="apellido">Apellido</Label>
                        <Input id="apellido" v-model="form.apellido" :disabled="form.processing" />
                        <InputError :message="form.errors.apellido" />
                    </div>
                </div>
                <div class="flex w-full space-x-2">
                    <div class="flex-1 space-y-2">
                        <Label for="domicilio">Domicilio</Label>
                        <Input id="domicilio" v-model="form.domicilio" :disabled="form.processing" />
                        <InputError :message="form.errors.domicilio" />
                    </div>
                </div>
                <Separator />
                <div class="flex w-full items-start space-x-2">
                    <div class="basis-1xs space-y-2">
                        <Label for="nss">NSS</Label>
                        <Input id="nss" v-model="form.nss" :disabled="form.processing" />
                        <InputError :message="form.errors.nss" />
                    </div>
                    <div class="basis-1xs space-y-2">
                        <Label for="telefono">Teléfono</Label>
                        <Input id="telefono" type="tel" v-maska="'## #### ####'" v-model="form.telefono" :disabled="form.processing" />
                        <InputError :message="form.errors.telefono" />
                    </div>
                    <div class="flex flex-1 justify-center space-x-2">
                        <div class="basis-3xs space-y-2">
                            <Label for="nolicencia">No. Licencia</Label>
                            <Input id="nolicencia" v-model="form.nolicencia" :disabled="form.processing" />
                            <InputError :message="form.errors.nolicencia" />
                        </div>
                        <div class="basis-3xs space-y-2">
                            <Label for="noexpediente">No. Expediente medico</Label>
                            <Input id="noexpediente" v-model="form.noexpediente" :disabled="form.processing" />
                            <InputError :message="form.errors.noexpediente" />
                        </div>
                    </div>
                </div>
                <Separator />
                <div class="flex w-full space-x-2">
                    <div class="flex-1 space-y-2">
                        <Label for="nota">Nota de operador</Label>
                        <Textarea id="nota" v-model="form.nota" :disabled="form.processing" />
                        <InputError :message="form.errors.nota" />
                    </div>
                </div>
            </CardContent>
            <CardFooter class="flex items-end justify-end space-x-2">
                <Button type="submit" :disabled="form.processing">
                    <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                    <SaveIcon v-else class="mr-2 h-4 w-4" /> {{ form.processing ? 'Guardando...' : buttonText }}
                </Button>
            </CardFooter>
        </form>
    </Card>
</template>
