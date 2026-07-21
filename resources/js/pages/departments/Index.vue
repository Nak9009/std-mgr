<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import type { PaginatedDepartments, Department } from '@/types';
import * as departmentsRoutes from '@/routes/departments';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';

import { ref } from 'vue';
import { watchDebounced } from '@vueuse/core';
import { Input } from '@/components/ui/input';
import { Button } from '@/components/ui/button';
import { MoreHorizontal, Search, Trash, Edit } from '@lucide/vue';
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

const props = defineProps<{
    departments: PaginatedDepartments;
    filters?: Record<string, string>;
}>();

const search = ref(props.filters?.search ?? '');

watchDebounced(search, (value) => {
    router.get(
        departmentsRoutes.index().url,
        { search: value },
        { preserveState: true, replace: true }
    );
}, { debounce: 300 });

const deleteDialogOpen = ref(false);
const departmentToDelete = ref<Department | null>(null);

function confirmDelete(department: Department) {
    departmentToDelete.value = department;
    deleteDialogOpen.value = true;
}

function destroy() {
    if (!departmentToDelete.value) return;
    router.delete(departmentsRoutes.destroy(departmentToDelete.value.id).url, {
        onSuccess: () => {
            deleteDialogOpen.value = false;
            departmentToDelete.value = null;
        }
    });
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
        <div class="flex items-center justify-between">
            <div class="relative w-full max-w-sm items-center">
                <Search class="absolute left-2.5 top-2.5 h-4 w-4 text-muted-foreground" />
                <Input
                    v-model="search"
                    type="search"
                    placeholder="Search departments..."
                    class="pl-8"
                />
            </div>
            <Button variant="outline">
                Filter
            </Button>
        </div>

        <div class="rounded-md border">
            <Table>
                <TableHeader>
                    <TableRow>
                        <TableHead>Name</TableHead>
                        <TableHead>Description</TableHead>
                        <TableHead class="w-[150px] text-right">Actions</TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    <TableRow
                        v-for="department in props.departments.data"
                        :key="department.id"
                    >
                        <TableCell class="font-medium">{{ department.name }}</TableCell>
                        <TableCell>{{ department.description }}</TableCell>
                        <TableCell class="text-right">
                            <DropdownMenu>
                                <DropdownMenuTrigger as-child>
                                    <Button variant="ghost" class="h-8 w-8 p-0">
                                        <span class="sr-only">Open menu</span>
                                        <MoreHorizontal class="h-4 w-4" />
                                    </Button>
                                </DropdownMenuTrigger>
                                <DropdownMenuContent align="end">
                                    <DropdownMenuLabel>Actions</DropdownMenuLabel>
                                    <DropdownMenuItem as-child>
                                        <Link :href="departmentsRoutes.edit(department.id).url">
                                            <Edit class="mr-2 h-4 w-4" />
                                            Edit
                                        </Link>
                                    </DropdownMenuItem>
                                    <DropdownMenuSeparator />
                                    <DropdownMenuItem @click="confirmDelete(department)" class="text-red-600 focus:bg-red-50 focus:text-red-600 cursor-pointer">
                                        <Trash class="mr-2 h-4 w-4" />
                                        Delete
                                    </DropdownMenuItem>
                                </DropdownMenuContent>
                            </DropdownMenu>
                        </TableCell>
                    </TableRow>
                    <TableRow v-if="props.departments.data.length === 0">
                        <TableCell colspan="3" class="h-24 text-center text-muted-foreground">
                            No departments found.
                        </TableCell>
                    </TableRow>
                </TableBody>
            </Table>
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

        <AlertDialog v-model:open="deleteDialogOpen">
            <AlertDialogContent>
                <AlertDialogHeader>
                    <AlertDialogTitle>Are you absolutely sure?</AlertDialogTitle>
                    <AlertDialogDescription>
                        This action cannot be undone. This will permanently delete the 
                        <span class="font-bold">{{ departmentToDelete?.name }}</span> department.
                    </AlertDialogDescription>
                </AlertDialogHeader>
                <AlertDialogFooter>
                    <AlertDialogCancel @click="deleteDialogOpen = false">Cancel</AlertDialogCancel>
                    <AlertDialogAction @click="destroy" class="bg-red-600 focus:ring-red-600">Delete</AlertDialogAction>
                </AlertDialogFooter>
            </AlertDialogContent>
        </AlertDialog>
    </div>
</template>
