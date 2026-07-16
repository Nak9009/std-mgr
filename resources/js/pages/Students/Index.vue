<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import students from '@/routes/students';

const props = defineProps<{
    students: {
        data: Array<{
            id: number;
            first_name: string;
            last_name: string;
            student_id: string;
            email: string;
            phone: string;
            status: string;
        }>;
        links: Array<any>;
    };
}>();

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Students',
                href: students.index(),
            },
        ],
    },
});

const form = useForm({});
const deleteStudent = (id: number) => {
    if (confirm('Are you sure you want to delete this student?')) {
        form.delete(students.destroy({ student: id }).url);
    }
};
</script>

<template>
    <Head title="Students" />

    <div class="flex h-full flex-1 flex-col gap-4 p-4">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold tracking-tight">Students</h1>
            <Button as-child>
                <Link :href="students.create()">Add Student</Link>
            </Button>
        </div>

        <div class="rounded-md border bg-white dark:bg-zinc-950">
            <div class="relative w-full overflow-auto">
                <table class="w-full caption-bottom text-sm">
                    <thead class="[&_tr]:border-b">
                        <tr class="border-b transition-colors hover:bg-zinc-100/50 data-[state=selected]:bg-zinc-100 dark:hover:bg-zinc-800/50 dark:data-[state=selected]:bg-zinc-800">
                            <th class="h-12 px-4 text-left align-middle font-medium text-zinc-500 dark:text-zinc-400">ID</th>
                            <th class="h-12 px-4 text-left align-middle font-medium text-zinc-500 dark:text-zinc-400">Name</th>
                            <th class="h-12 px-4 text-left align-middle font-medium text-zinc-500 dark:text-zinc-400">Student ID</th>
                            <th class="h-12 px-4 text-left align-middle font-medium text-zinc-500 dark:text-zinc-400">Email</th>
                            <th class="h-12 px-4 text-left align-middle font-medium text-zinc-500 dark:text-zinc-400">Status</th>
                            <th class="h-12 px-4 text-right align-middle font-medium text-zinc-500 dark:text-zinc-400">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="[&_tr:last-child]:border-0">
                        <tr v-for="student in props.students.data" :key="student.id" class="border-b transition-colors hover:bg-zinc-100/50 dark:hover:bg-zinc-800/50">
                            <td class="p-4 align-middle">{{ student.id }}</td>
                            <td class="p-4 align-middle">{{ student.first_name }} {{ student.last_name }}</td>
                            <td class="p-4 align-middle">{{ student.student_id }}</td>
                            <td class="p-4 align-middle">{{ student.email }}</td>
                            <td class="p-4 align-middle">
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-zinc-950 focus:ring-offset-2" :class="student.status === 'active' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300'">
                                    {{ student.status }}
                                </span>
                            </td>
                            <td class="p-4 align-middle text-right">
                                <div class="flex justify-end gap-2">
                                    <Button variant="outline" size="sm" as-child>
                                        <Link :href="students.edit({ student: student.id })">Edit</Link>
                                    </Button>
                                    <Button variant="destructive" size="sm" @click="deleteStudent(student.id)">Delete</Button>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="props.students.data.length === 0">
                            <td colspan="6" class="h-24 text-center">No students found.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div v-if="props.students.links && props.students.links.length > 3" class="flex items-center justify-between px-4 py-3">
                <div class="flex flex-1 justify-between sm:hidden">
                    <Button variant="outline" :disabled="!props.students.links[0].url" as-child>
                        <Link v-if="props.students.links[0].url" :href="props.students.links[0].url">Previous</Link>
                        <span v-else>Previous</span>
                    </Button>
                    <Button variant="outline" :disabled="!props.students.links[props.students.links.length - 1].url" as-child>
                        <Link v-if="props.students.links[props.students.links.length - 1].url" :href="props.students.links[props.students.links.length - 1].url">Next</Link>
                        <span v-else>Next</span>
                    </Button>
                </div>
            </div>
        </div>
    </div>
</template>
