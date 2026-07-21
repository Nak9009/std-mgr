<script setup lang="ts">
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import type { PaginatedDepartments, Department } from '@/types';
import * as departmentsRoutes from '@/routes/departments';
import { Input } from '@/components/ui/input';
import { Button } from '@/components/ui/button';
import {
    Form,
    FormControl,
    FormDescription,
    FormField,
    FormItem,
    FormLabel,
    FormMessage,
} from '@/components/ui/form';
import { Textarea } from '@/components/ui/textarea';

const props = defineProps<{
    departments: PaginatedDepartments;
}>();

const form = useForm({
    name: '',
    description: '',
});

function onSubmit() {
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
        <!-- Create Department -->
        <h2 class="text-xl font-semibold">Create Department</h2>

        <Form class="w-2/3 space-y-6" @submit="onSubmit">
            <FormField v-slot="{ componentField }" name="name">
                <FormItem>
                    <FormLabel>Name</FormLabel>
                    <FormControl>
                        <Input
                            type="text"
                            placeholder="shadcn"
                            v-bind="componentField"
                        />
                    </FormControl>
                    <FormDescription>
                        This is your public display name.
                    </FormDescription>
                    <FormMessage />
                </FormItem>
                <FormItem>
                    <FormLabel>Description</FormLabel>
                    <FormControl>
                        <Textarea
                            type="text"
                            placeholder="Description"
                            v-bind="componentField"
                        />
                    </FormControl>
                    <FormDescription>
                        This is your department description.
                    </FormDescription>
                    <FormMessage />
                </FormItem>
            </FormField>
            <Button type="submit"> Submit </Button>
        </form>
    </div>
</template>
