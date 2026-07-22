<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { dashboard } from '@/routes';
import type { PaginatedStudents, Student } from '@/types';
import * as studentsRoutes from '@/routes/students';
import Button from '@/components/ui/button/Button.vue';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import {
    Pagination,
    PaginationContent,
    PaginationEllipsis,
    PaginationItem,
    PaginationNext,
    PaginationPrevious,
} from '@/components/ui/pagination';

const props = defineProps<{
    students: PaginatedStudents;
}>();

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Student',
                href: studentsRoutes.index().url,
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
            <Table>
                <TableHeader>
                    <TableRow>
                        <TableHead>Student ID</TableHead>
                        <TableHead>Name</TableHead>
                        <TableHead>Email</TableHead>
                        <TableHead>Grade</TableHead>
                        <TableHead>Status</TableHead>
                        <TableHead class="text-right">Actions</TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    <TableRow
                        v-for="student in props.students.data"
                        :key="student.id"
                    >
                        <TableCell>{{ student.student_id }}</TableCell>
                        <TableCell>
                            {{ student.first_name }} {{ student.last_name }}
                        </TableCell>
                        <TableCell>{{ student.email }}</TableCell>
                        <TableCell>{{ student.grade_level }}</TableCell>
                        <TableCell class="capitalize">
                            {{ student.status }}
                        </TableCell>
                        <TableCell class="text-right">
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
                        </TableCell>
                    </TableRow>
                    <TableRow v-if="props.students.data.length === 0">
                        <TableCell
                            colspan="6"
                            class="text-center text-muted-foreground"
                        >
                            No students yet.
                        </TableCell>
                    </TableRow>
                </TableBody>
            </Table>
        </div>

        <Pagination
            :total="props.students.total"
            :sibling-count="1"
            show-edges
            :default-page="props.students.current_page"
            :items-per-page="props.students.per_page"
        >
            <PaginationContent>
                <template v-for="(link, index) in props.students.links" :key="index">
                    <!-- Previous Button -->
                    <template v-if="index === 0">
                        <PaginationPrevious
                            v-if="link.url"
                            as-child
                        >
                            <Link :href="link.url" />
                        </PaginationPrevious>
                        <PaginationPrevious
                            v-else
                            disabled
                        />
                    </template>

                    <!-- Next Button -->
                    <template v-else-if="index === props.students.links.length - 1">
                        <PaginationNext
                            v-if="link.url"
                            as-child
                        >
                            <Link :href="link.url" />
                        </PaginationNext>
                        <PaginationNext
                            v-else
                            disabled
                        />
                    </template>

                    <!-- Ellipsis -->
                    <PaginationEllipsis v-else-if="link.label === '...'" />

                    <!-- Page Links -->
                    <PaginationItem
                        v-else
                        :value="Number(link.label)"
                        as-child
                        :isActive="link.active"
                    >
                        <Link :href="link.url || ''">
                            {{ link.label }}
                        </Link>
                    </PaginationItem>
                </template>
            </PaginationContent>
        </Pagination>
    </div>
</template>
