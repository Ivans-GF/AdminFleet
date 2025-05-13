<script setup lang="ts">
import IconPortada from '@/components/images/favicon.ico';
import type { HTMLAttributes } from 'vue';

defineOptions({
    inheritAttrs: false,
});

interface Props {
    className?: HTMLAttributes['class'];
}

defineProps<Props>();
</script>

<template>
    <img :src="IconPortada" :class="className" v-bind="$attrs" />
</template>
