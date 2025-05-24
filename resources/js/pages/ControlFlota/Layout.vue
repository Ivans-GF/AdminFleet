<script setup lang="ts">
import Heading from '@/components/Heading.vue';
import { Button } from '@/components/ui/button';
import { Separator } from '@/components/ui/separator';
import { type NavItem } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';

const sidebarNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        prefix: '/control-flota/index',
        href: route('index.controflota'),
    },
    {
        title: 'Operadores',
        prefix: '/control-flota/operadores',
        href: route('operadores.index'),
    },
    {
        title: 'Unidades',
        prefix: '/control-flota/unidades',
        href: route('unidades.index'),
    },
];

const page = usePage();

const currentPath = page.props.ziggy?.location ? new URL(page.props.ziggy.location).pathname : '';
</script>

<template>
    <div class="px-4 py-6">
        <Heading title="Control Flota" />

        <div class="flex flex-col space-y-8 md:space-y-0 lg:flex-row lg:space-y-0 lg:space-x-2">
            <aside class="w-full max-w-xl lg:w-48">
                <nav class="flex flex-col space-y-1 space-x-0">
                    <Button
                        v-for="item in sidebarNavItems"
                        :key="item.href"
                        variant="ghost"
                        :class="['w-full justify-start', { 'bg-muted': page.url.includes(item.prefix) }]"
                        as-child
                    >
                        <Link :href="item.href">
                            {{ item.title }}
                        </Link>
                    </Button>
                </nav>
            </aside>
            <Separator class="my-6 md:hidden" />
            <div class="flex-1 md:max-w-full">
                <section class="max-w-full space-y-2">
                    <slot />
                </section>
            </div>
        </div>
    </div>
</template>
