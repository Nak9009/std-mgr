<script setup lang="ts">
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import type { PaginatedDepartments, Department } from '@/types';
import * as departmentsRoutes from '@/routes/departments';

const props = defineProps<{
    departments: PaginatedDepartments;
}>();

const form = useForm({
    name: '',
    description: '',
});

function submit() {
    form.post(departmentsRoutes.store().url);
}

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Department',
                href: departmentsRoutes.index().url,
            },
            {
                title: 'Create',
                href: departmentsRoutes.create().url,
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
        <form @submit.prevent="submit">
            <input
                type="text"
                v-model="form.name"
                placeholder="Name"
                class="rounded border px-3 py-1"
            />
            <input
                type="text"
                v-model="form.description"
                placeholder="Description"
                class="rounded border px-3 py-1"
            />
            <button type="submit">Create</button>
        </form>
    </div>
</template>
