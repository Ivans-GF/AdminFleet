import type { PageProps } from '@inertiajs/core';
import type { LucideIcon } from 'lucide-vue-next';
import type { Config } from 'ziggy-js';

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavItem {
    title: string;
    prefix: string;
    href: string;
    icon?: LucideIcon;
    isActive?: boolean;
}

export interface SharedData extends PageProps {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    ziggy: Config & { location: string };
    sidebarOpen: boolean;
    flash: {
        sucess?: string;
        error?: string;
        info?: string;
        warning?: string;
    };
}

export interface User {
    id: number;
    name: string;
    email: string;
    avatar?: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
}

//ControlFlotilla
interface Operador {
    id: number;
    curp: string;
    rfc: string;
    nss: number;
    licencia: string;
    nombre: string;
    apellido: string;
    telefono: string;
    domicilio: string;
    nota: string;
}

export type BreadcrumbItemType = BreadcrumbItem;
