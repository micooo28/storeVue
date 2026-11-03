import type { LucideIcon } from '@lucide/vue';

export type BreadcrumbItem = {
    name: string;
    route: string;
};

export type NavItem = {
    name: string;
    icon: LucideIcon;
    route: string;
};
