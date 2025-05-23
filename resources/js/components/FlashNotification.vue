<script setup lang="ts">
import { Alert, AlertDescription, AlertTitle } from '@/components/ui/alert';
import { Button } from '@/components/ui/button';
import { type SharedData } from '@/types';
import { usePage } from '@inertiajs/vue3';
import { AlertTriangleIcon, CheckCircleIcon, InfoIcon, XCircleIcon, XIcon } from 'lucide-vue-next';
import { computed, onMounted, onUnmounted, ref, watch } from 'vue';

const page = usePage<SharedData>();
const show = ref<boolean>(false);
const timeout = ref<number | null>(null);
const progressBarWidth = ref(100); // Initial width for the progress bar
const DURATION = 5000; // 5 seconds for auto-hide

const types = {
    success: {
        icon: CheckCircleIcon,
        title: 'Éxito',
        class: 'border-green-500 bg-green-50 text-green-800 dark:bg-green-900/50 dark:text-green-300',
        progressBarClass: 'bg-green-400',
    },
    error: {
        icon: XCircleIcon,
        title: 'Error',
        class: 'border-rose-500 bg-rose-50 text-rose-800 dark:bg-rose-900/50 dark:text-rose-300',
        progressBarClass: 'bg-rose-400',
    },
    info: {
        icon: InfoIcon,
        title: 'Información',
        class: 'border-blue-500 bg-blue-50 text-blue-800 dark:bg-blue-900/50 dark:text-blue-300',
        progressBarClass: 'bg-blue-400',
    },
    warning: {
        icon: AlertTriangleIcon,
        title: 'Advertencia',
        class: 'border-yellow-500 bg-yellow-50 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-300',
        progressBarClass: 'bg-yellow-400',
    },
};

const notificationType = computed(() => {
    if (page.props.flash.success) return 'success';
    if (page.props.flash.error) return 'error';
    if (page.props.flash.info) return 'info';
    if (page.props.flash.warning) return 'warning';
    return 'info'; // Por defecto
});

const message = computed(() => {
    return page.props.flash.success || page.props.flash.error || page.props.flash.info || page.props.flash.warning || '';
});

let interval: number | null = null;

const startTimer = () => {
    if (timeout.value) clearTimeout(timeout.value);
    if (interval) clearInterval(interval);

    progressBarWidth.value = 100;
    const startTime = Date.now();

    interval = window.setInterval(() => {
        const elapsedTime = Date.now() - startTime;
        const remainingTime = DURATION - elapsedTime;
        progressBarWidth.value = (remainingTime / DURATION) * 100;

        if (remainingTime <= 0) {
            closeNotification();
        }
    }, 50); // Update every 50ms for a smooth animation

    timeout.value = window.setTimeout(() => {
        show.value = false;
        if (interval) clearInterval(interval);
    }, DURATION);
};

onMounted(() => {
    if (message.value) {
        show.value = true;
        startTimer();
    }
});

onUnmounted(() => {
    if (timeout.value) {
        clearTimeout(timeout.value);
    }
    if (interval) {
        clearInterval(interval);
    }
});

watch(
    () => message.value,
    (newMessage) => {
        if (newMessage) {
            show.value = true;
            startTimer();
        }
    },
);

const closeNotification = () => {
    show.value = false;
    if (timeout.value) clearTimeout(timeout.value);
    if (interval) clearInterval(interval);
};
</script>

<template>
    <div v-if="show && message" class="fixed right-4 bottom-4 z-50 w-full max-w-md">
        <Alert :class="types[notificationType].class + ' relative overflow-hidden'">
            <component :is="types[notificationType].icon" class="h-5 w-5" />
            <AlertTitle>{{ types[notificationType].title }}</AlertTitle>
            <AlertDescription>{{ message }}</AlertDescription>
            <Button variant="ghost" size="icon" class="absolute top-2 right-2 z-10" @click="closeNotification">
                <XIcon class="h-4 w-4" />
                <span class="sr-only">Cerrar</span>
            </Button>
            <div
                class="absolute bottom-0 left-0 h-1 transition-all ease-linear"
                :class="types[notificationType].progressBarClass"
                :style="{ width: progressBarWidth + '%' }"
            ></div>
        </Alert>
    </div>
</template>
