<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import students from '@/routes/students';

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Students',
                href: students.index(),
            },
            {
                title: 'Create',
                href: students.create(),
            },
        ],
    },
});

const form = useForm({
    first_name: '',
    last_name: '',
    student_id: '',
    email: '',
    phone: '',
    address: '',
    gender: 'male',
    status: 'active',
});

const submit = () => {
    form.post(students.store().url);
};
</script>

<template>
    <Head title="Create Student" />

    <div class="flex h-full flex-1 flex-col gap-4 p-4 max-w-3xl mx-auto w-full">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold tracking-tight">Create Student</h1>
            <Button variant="outline" as-child>
                <Link :href="students.index()">Back</Link>
            </Button>
        </div>

        <div class="rounded-md border bg-white dark:bg-zinc-950 p-6">
            <form @submit.prevent="submit" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <Label for="first_name">First Name</Label>
                        <Input id="first_name" v-model="form.first_name" type="text" required autofocus />
                        <p v-if="form.errors.first_name" class="text-[0.8rem] font-medium text-destructive">{{ form.errors.first_name }}</p>
                    </div>

                    <div class="space-y-2">
                        <Label for="last_name">Last Name</Label>
                        <Input id="last_name" v-model="form.last_name" type="text" required />
                        <p v-if="form.errors.last_name" class="text-[0.8rem] font-medium text-destructive">{{ form.errors.last_name }}</p>
                    </div>

                    <div class="space-y-2">
                        <Label for="student_id">Student ID</Label>
                        <Input id="student_id" v-model="form.student_id" type="text" required />
                        <p v-if="form.errors.student_id" class="text-[0.8rem] font-medium text-destructive">{{ form.errors.student_id }}</p>
                    </div>

                    <div class="space-y-2">
                        <Label for="email">Email</Label>
                        <Input id="email" v-model="form.email" type="email" required />
                        <p v-if="form.errors.email" class="text-[0.8rem] font-medium text-destructive">{{ form.errors.email }}</p>
                    </div>

                    <div class="space-y-2">
                        <Label for="phone">Phone</Label>
                        <Input id="phone" v-model="form.phone" type="text" />
                        <p v-if="form.errors.phone" class="text-[0.8rem] font-medium text-destructive">{{ form.errors.phone }}</p>
                    </div>

                    <div class="space-y-2">
                        <Label for="gender">Gender</Label>
                        <select id="gender" v-model="form.gender" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                        <p v-if="form.errors.gender" class="text-[0.8rem] font-medium text-destructive">{{ form.errors.gender }}</p>
                    </div>

                    <div class="space-y-2 md:col-span-2">
                        <Label for="address">Address</Label>
                        <Input id="address" v-model="form.address" type="text" />
                        <p v-if="form.errors.address" class="text-[0.8rem] font-medium text-destructive">{{ form.errors.address }}</p>
                    </div>
                    
                    <div class="space-y-2 md:col-span-2">
                        <Label for="status">Status</Label>
                        <select id="status" v-model="form.status" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                        <p v-if="form.errors.status" class="text-[0.8rem] font-medium text-destructive">{{ form.errors.status }}</p>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <Button type="submit" :disabled="form.processing">Save Student</Button>
                </div>
            </form>
        </div>
    </div>
</template>
