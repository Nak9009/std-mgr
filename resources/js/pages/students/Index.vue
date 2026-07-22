<script setup lang="ts">
import { ref, watch } from 'vue';
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
import { Input } from '@/components/ui/input';
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import {
    AlertDialog,
    AlertDialogAction,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
} from '@/components/ui/alert-dialog';
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { MoreHorizontal, Search } from '@lucide/vue';

const props = defineProps<{
    students: PaginatedStudents;
    filters?: {
        search?: string;
        status?: string;
        grade_level?: string;
    };
}>();

const search = ref(props.filters?.search ?? '');
const status = ref(props.filters?.status || 'all');
const gradeLevel = ref(props.filters?.grade_level || 'all');

watch([search, status, gradeLevel], ([newSearch, newStatus, newGradeLevel]) => {
    router.get(
        studentsRoutes.index().url,
        {
            search: newSearch,
            status: newStatus === 'all' ? undefined : newStatus,
            grade_level: newGradeLevel === 'all' ? undefined : newGradeLevel,
        },
        {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        },
    );
});

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

const isDeleteDialogOpen = ref(false);
const studentToDelete = ref<Student | null>(null);

function confirmDestroy(student: Student) {
    studentToDelete.value = student;
    isDeleteDialogOpen.value = true;
}

function destroyStudent() {
    if (!studentToDelete.value) return;
    router.delete(studentsRoutes.destroy(studentToDelete.value.id).url, {
        onSuccess: () => {
            isDeleteDialogOpen.value = false;
            studentToDelete.value = null;
        },
    });
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

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
            <div class="relative w-full sm:max-w-sm">
                <Search
                    class="absolute top-2.5 left-2.5 h-4 w-4 text-muted-foreground"
                />
                <Input
                    v-model="search"
                    placeholder="Search students..."
                    class="pl-8"
                />
            </div>
            <div class="flex w-full gap-2 sm:ml-auto sm:w-auto">
                <Select v-model="status">
                    <SelectTrigger class="w-full sm:w-[130px]">
                        <SelectValue placeholder="Status" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectGroup>
                            <SelectItem value="all">All</SelectItem>
                            <SelectItem value="active">Active</SelectItem>
                            <SelectItem value="inactive">Inactive</SelectItem>
                            <SelectItem value="graduated">Graduated</SelectItem>
                        </SelectGroup>
                    </SelectContent>
                </Select>
                <Select v-model="gradeLevel">
                    <SelectTrigger class="w-full sm:w-[130px]">
                        <SelectValue placeholder="Grade" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectGroup>
                            <SelectItem value="all">All</SelectItem>
                            <SelectItem value="1">Grade 1</SelectItem>
                            <SelectItem value="2">Grade 2</SelectItem>
                            <SelectItem value="3">Grade 3</SelectItem>
                            <SelectItem value="4">Grade 4</SelectItem>
                            <SelectItem value="5">Grade 5</SelectItem>
                            <SelectItem value="6">Grade 6</SelectItem>
                            <SelectItem value="7">Grade 7</SelectItem>
                            <SelectItem value="8">Grade 8</SelectItem>
                            <SelectItem value="9">Grade 9</SelectItem>
                            <SelectItem value="10">Grade 10</SelectItem>
                            <SelectItem value="11">Grade 11</SelectItem>
                            <SelectItem value="12">Grade 12</SelectItem>
                        </SelectGroup>
                    </SelectContent>
                </Select>
            </div>
        </div>

        <div class="overflow-x-auto rounded-lg border">
            <Table>
                <TableHeader>
                    <TableRow>
                        <TableHead class="w-[60px]"></TableHead>
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
                        <TableCell>
                            <Avatar class="h-10 w-10">
                                <AvatarImage
                                    v-if="student.photo_url"
                                    :src="student.photo_url"
                                    :alt="student.first_name"
                                />
                                <AvatarFallback
                                    >{{ student.first_name.charAt(0)
                                    }}{{
                                        student.last_name.charAt(0)
                                    }}</AvatarFallback
                                >
                            </Avatar>
                        </TableCell>
                        <TableCell>{{ student.student_id }}</TableCell>
                        <TableCell class="font-medium">
                            {{ student.first_name }} {{ student.last_name }}
                        </TableCell>
                        <TableCell>{{ student.email }}</TableCell>
                        <TableCell>{{ student.grade_level }}</TableCell>
                        <TableCell class="capitalize">
                            {{ student.status }}
                        </TableCell>
                        <TableCell class="text-right">
                            <DropdownMenu>
                                <DropdownMenuTrigger as-child>
                                    <Button variant="ghost" class="h-8 w-8 p-0">
                                        <span class="sr-only">Open menu</span>
                                        <MoreHorizontal class="h-4 w-4" />
                                    </Button>
                                </DropdownMenuTrigger>
                                <DropdownMenuContent align="end">
                                    <DropdownMenuLabel
                                        >Actions</DropdownMenuLabel
                                    >
                                    <DropdownMenuItem as-child>
                                        <Link
                                            :href="
                                                studentsRoutes.edit(student.id)
                                                    .url
                                            "
                                        >
                                            Edit
                                        </Link>
                                    </DropdownMenuItem>
                                    <DropdownMenuSeparator />
                                    <DropdownMenuItem
                                        @click="confirmDestroy(student)"
                                        class="text-destructive focus:text-destructive"
                                    >
                                        Delete
                                    </DropdownMenuItem>
                                </DropdownMenuContent>
                            </DropdownMenu>
                        </TableCell>
                    </TableRow>
                    <TableRow v-if="props.students.data.length === 0">
                        <TableCell
                            colspan="7"
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
                <template
                    v-for="(link, index) in props.students.links"
                    :key="index"
                >
                    <!-- Previous Button -->
                    <template v-if="index === 0">
                        <PaginationPrevious v-if="link.url" as-child>
                            <Link :href="link.url" />
                        </PaginationPrevious>
                        <PaginationPrevious v-else disabled />
                    </template>

                    <!-- Next Button -->
                    <template
                        v-else-if="index === props.students.links.length - 1"
                    >
                        <PaginationNext v-if="link.url" as-child>
                            <Link :href="link.url" />
                        </PaginationNext>
                        <PaginationNext v-else disabled />
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

        <AlertDialog :open="isDeleteDialogOpen" @update:open="isDeleteDialogOpen = $event">
            <AlertDialogContent>
                <AlertDialogHeader>
                    <AlertDialogTitle>Are you absolutely sure?</AlertDialogTitle>
                    <AlertDialogDescription>
                        This action cannot be undone. This will permanently delete 
                        <span v-if="studentToDelete" class="font-semibold text-foreground">
                            {{ studentToDelete.first_name }} {{ studentToDelete.last_name }}
                        </span>.
                    </AlertDialogDescription>
                </AlertDialogHeader>
                <AlertDialogFooter>
                    <AlertDialogCancel @click="isDeleteDialogOpen = false">Cancel</AlertDialogCancel>
                    <AlertDialogAction @click="destroyStudent" class="bg-destructive text-destructive-foreground hover:bg-destructive/90">
                        Continue
                    </AlertDialogAction>
                </AlertDialogFooter>
            </AlertDialogContent>
        </AlertDialog>
    </div>
</template>
