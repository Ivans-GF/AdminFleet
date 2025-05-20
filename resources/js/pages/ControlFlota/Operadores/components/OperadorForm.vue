<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import { Link } from '@inertiajs/vue3';
import { Undo2 } from 'lucide-vue-next';
import { computed } from 'vue';

type OperadorForm = 'create' | 'edit';

interface Props {
    mode: OperadorForm;
}

const props = withDefaults(defineProps<Props>(), {
    mode: 'create',
});
const buttonText = computed(() => (props.mode === 'create' ? 'Guardar' : 'Actualizar Tarea'));
</script>
<template>
    <Card>
        <CardHeader>
            <CardTitle>
                <div class="flex flex-row justify-end space-x-2">
                    <Button as-child>
                        <Link :href="route('operadores/index')"> <Undo2 class="mr-2 h-4 w-4" />Regresar</Link>
                    </Button>
                </div>
            </CardTitle>
        </CardHeader>
        <form @submit.prevent="">
            <CardContent class="space-y-4">
                <div class="space-y-2">
                    <Label for="title">Título</Label>
                    <Input id="title" placeholder="Ingresa el título de la tarea" />
                    <InputError />
                </div>
            </CardContent>
            <CardFooter class="flex justify-between"> </CardFooter>
        </form>
    </Card>
</template>
