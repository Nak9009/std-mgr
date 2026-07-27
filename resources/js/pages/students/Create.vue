<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3';
import { dashboard } from '@/routes';
import * as studentsRoutes from '@/routes/students';
import StudentForm from './partials/StudentForm.vue';
import { toast } from 'vue-sonner';

const form = useForm({
    first_name: '',
    last_name: '',
    email: '',
    phone: '',
    student_id: '',
    date_of_birth: '',
    grade_level: '',
    status: 'active',
    photo: null as File | null,
    base64: null as string | null,
    blob: null as string | null,
});

function submit() {
    form.post(studentsRoutes.store().url, {
        forceFormData: true,
        onSuccess: () => {
            toast.success('Student created successfully');
        },
    });
}

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Dashboard',
                href: dashboard(),
            },
        ],
    },
});
</script>

<template>
    <Head title="Students List" />

    <div
        class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
    >
        <div class="max-w-3xl space-y-6">
            <h1 class="text-2xl font-semibold">Add Student</h1>
            <StudentForm
                :form="form"
                @submit="submit"
                submitText="Save Student"
            />
        </div>
    </div>
</template>
