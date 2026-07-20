<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { dashboard } from '@/routes';
import type { PaginatedStudents, Student } from '@/types';
import * as studentsRoutes from '@/routes/students';

const props = defineProps<{
    students: PaginatedStudents;
}>();

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

function destroy(student: Student) {
    if (
        !confirm(
            `Are you sure you want to delete ${student.first_name} ${student.last_name}?`,
        )
    ) {
        return;
    }
    router.delete(studentsRoutes.destroy(student.id).url);
}
</script>

<template>
    <Head title="Students List" />

    <div
        class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
    >
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-semibold">Students</h1>
            <Link :href="studentsRoutes.create().url">
                <Button>Add Student</Button>
            </Link>
        </div>

        <div class="overflow-x-auto rounded-lg border">
            <table class="w-full text-sm">
                <thead class="bg-muted/50 text-left">
                    <tr>
                        <th class="p-3">Student ID</th>
                        <th class="p-3">Name</th>
                        <th class="p-3">Email</th>
                        <th class="p-3">Grade</th>
                        <th class="p-3">Status</th>
                        <th class="p-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="student in props.students.data"
                        :key="student.id"
                        class="border-t"
                    >
                        <td class="p-3">{{ student.student_id }}</td>
                        <td class="p-3">
                            {{ student.first_name }} {{ student.last_name }}
                        </td>
                        <td class="p-3">{{ student.email }}</td>
                        <td class="p-3">{{ student.grade_level }}</td>
                        <td class="p-3 capitalize">{{ student.status }}</td>
                        <td class="space-x-2 p-3 text-right">
                            <Link
                                :href="studentsRoutes.edit(student.id).url"
                                class="text-sm underline"
                            >
                                Edit
                            </Link>
                            <button
                                class="text-sm underline"
                                @click="destroy(student)"
                            >
                                Delete
                            </button>
                        </td>
                    </tr>
                    <tr v-if="props.students.data.length === 0">
                        <td
                            colspan="6"
                            class="p-6 text-center text-muted-foreground"
                        >
                            No students yet.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="flex flex-wrap gap-2">
            <Link
                v-for="link in props.students.links"
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
