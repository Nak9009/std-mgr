<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3';
import { dashboard } from '@/routes';
import * as studentsRoutes from '@/routes/students';
import { Input } from '@/components/ui/input';
import {
    FormControl,
    FormDescription,
    FormField,
    FormItem,
    FormLabel,
    FormMessage,
} from '@/components/ui/form';
import { ref } from 'vue';

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
});

const photoPreview = ref<string | null>(null);

function onPhotoChange(event: Event) {
    const file = (event.target as HTMLInputElement).files?.[0] ?? null;
    form.photo = file;
    photoPreview.value = file ? URL.createObjectURL(file) : null;
}

function submit() {
    form.post(studentsRoutes.store().url);
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
        <h1 class="text-2xl font-semibold">Add Student</h1>

        <form class="space-y-4" @submit.prevent="submit">
            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-1">
                    <Label for="first_name">First Name</Label>
                    <Input id="first_name" v-model="form.first_name" />
                    <p
                        v-if="form.errors.first_name"
                        class="text-sm text-destructive"
                    >
                        {{ form.errors.first_name }}
                    </p>
                </div>
                <div class="space-y-1">
                    <Label for="last_name">Last Name</Label>
                    <Input id="last_name" v-model="form.last_name" />
                    <p
                        v-if="form.errors.last_name"
                        class="text-sm text-destructive"
                    >
                        {{ form.errors.last_name }}
                    </p>
                </div>
            </div>

            <div class="space-y-1">
                <Label for="email">Email</Label>
                <Input id="email" type="email" v-model="form.email" />
                <p v-if="form.errors.email" class="text-sm text-destructive">
                    {{ form.errors.email }}
                </p>
            </div>

            <div class="space-y-1">
                <Label for="phone">Phone</Label>
                <Input id="phone" v-model="form.phone" />
                <p v-if="form.errors.phone" class="text-sm text-destructive">
                    {{ form.errors.phone }}
                </p>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-1">
                    <Label for="student_id">Student ID</Label>
                    <Input id="student_id" v-model="form.student_id" />
                    <p
                        v-if="form.errors.student_id"
                        class="text-sm text-destructive"
                    >
                        {{ form.errors.student_id }}
                    </p>
                </div>
                <div class="space-y-1">
                    <Label for="date_of_birth">Date of Birth</Label>
                    <Input
                        id="date_of_birth"
                        type="date"
                        v-model="form.date_of_birth"
                    />
                    <p
                        v-if="form.errors.date_of_birth"
                        class="text-sm text-destructive"
                    >
                        {{ form.errors.date_of_birth }}
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-1">
                    <Label for="grade_level">Grade Level</Label>
                    <Input
                        id="grade_level"
                        v-model="form.grade_level"
                        placeholder="e.g. 10"
                    />
                    <p
                        v-if="form.errors.grade_level"
                        class="text-sm text-destructive"
                    >
                        {{ form.errors.grade_level }}
                    </p>
                </div>
                <div class="space-y-1">
                    <Label for="status">Status</Label>
                    <select
                        id="status"
                        v-model="form.status"
                        class="w-full rounded-md border px-3 py-2 text-sm"
                    >
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="graduated">Graduated</option>
                    </select>
                    <p
                        v-if="form.errors.status"
                        class="text-sm text-destructive"
                    >
                        {{ form.errors.status }}
                    </p>
                </div>
            </div>
            <div class="space-y-1">
                <Label for="photo">Photo</Label>
                <input
                    id="photo"
                    type="file"
                    accept="image/*"
                    @change="onPhotoChange"
                    class="text-sm"
                />
                <img
                    v-if="photoPreview"
                    :src="photoPreview"
                    class="mt-2 h-20 w-20 rounded-full object-cover"
                />
                <p v-if="form.errors.photo" class="text-sm text-destructive">
                    {{ form.errors.photo }}
                </p>
            </div>

            <Button type="submit" :disabled="form.processing"
                >Save Student</Button
            >
        </form>
    </div>
</template>
