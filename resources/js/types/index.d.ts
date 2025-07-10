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
    nombre: string;
    apellido: string;
    telefono: string;
    domicilio: string;
    nota: string;
    estado: number;
    nolicencia: string;
    noexpediente: number;
    documentosestatus: number;
    categoria?: string; // Opciones  para realizar consultar
    archivo?: string; // Opciones para realizar consultar
    fechavigencia?: date; // Opciones para realizar consultar
    dias_restanteslicencia?: date; // Opciones para realizar consultar
    archivo_licencia_url?: string; // Opciones para realizar consultar
}

interface Licencia {
    id: number;
    idoperador: number;
    archivo: string;
    nolicencia: string;
    categoria: string;
    fechavigencia: string;
    comentario: string;
    estado: number;
}

export type BreadcrumbItemType = BreadcrumbItem;
