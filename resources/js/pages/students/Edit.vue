<script setup lang="ts">
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import { dashboard } from '@/routes';
import type { PaginatedStudents, Student } from '@/types';
import * as studentsRoutes from '@/routes/students';
import StudentForm from './partials/StudentForm.vue';
import { toast } from 'vue-sonner';

const props = defineProps<{
    student: Student;
}>();

const form = useForm({
    first_name: props.student.first_name,
    last_name: props.student.last_name,
    email: props.student.email,
    phone: props.student.phone ?? '',
    student_id: props.student.student_id,
    date_of_birth: props.student.date_of_birth ?? '',
    grade_level: props.student.grade_level,
    status: props.student.status,
    photo: null as File | null,
});

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Dashboard',
                href: dashboard(),
            },
            {
                title: 'Students',
                href: studentsRoutes.index().url,
            },
            {
                title: 'Edit',
                href: '#',
            },
        ],
    },
});

// function submit() {
//     form.put(studentsRoutes.update(props.student.id).url);
// }

function submit() {
    form.transform((data) => ({ ...data, _method: 'put' })).post(
        studentsRoutes.update(props.student.id).url,
        {
            forceFormData: true,
            onSuccess: () => {
                toast.success('Student updated successfully');
            },
        }
    );
}
</script>

<template>
    <Head title="Students List" />

    <div
        class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
    >
        <div class="max-w-3xl space-y-6">
            <h1 class="text-2xl font-semibold">Edit Student</h1>
            <StudentForm 
                :form="form" 
                :initialPhoto="props.student.photo_url"
                @submit="submit" 
                submitText="Update Student" 
            />
        </div>
    </div>
</template>
