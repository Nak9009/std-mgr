<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import type { PaginatedDepartments, Department } from '@/types';
import * as departmentsRoutes from '@/routes/departments';

const props = defineProps<{
    departments: PaginatedDepartments;
}>();

function destroy(department: Department) {
    if (
        !confirm(
            `Are you sure you want to delete ${department.name} ${department.description}?`,
        )
    ) {
        return;
    }
    router.delete(departmentsRoutes.destroy(department.id).url);
}

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Department',
                href: '#',
            },
        ],
    },
});
</script>

<template>
    <Head title="Department" />

    <div
        class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
    >
        <div
            v-for="department in props.departments.data"
            :key="department.id"
            class="rounded-lg border p-4"
        >
            <p>{{ department.name }}</p>
            <p>{{ department.description }}</p>
            <Link
                :href="departmentsRoutes.edit(department.id).url"
                class="rounded px-3 py-1 text-sm"
            >
                Edit
            </Link>
            <button @click="destroy(department)">Delete</button>
        </div>

        <div class="flex flex-wrap gap-2">
            <Link
                v-for="link in props.departments.links"
                :key="link.label"
                :href="link.url ?? ''"
                v-html="link.label"
                class="rounded px-3 py-1 text-sm"
                :class="{
                    'bg-primary text-primary-foreground': link.active,
                    'pointer-events-none opacity-50': !link.url,
                    'hover:bg-muted': link.url && !link.active,
                }"
            />
        </div>
    </div>
</template>
