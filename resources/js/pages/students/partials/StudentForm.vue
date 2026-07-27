<script setup lang="ts">
import { ref } from 'vue';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Button } from '@/components/ui/button';
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';

const props = defineProps<{
    form: any;
    initialPhoto?: string | null;
    initialBase64?: string | null;
    initialBlob?: string | null;
    submitText?: string;
}>();

const emit = defineEmits<{
    (e: 'submit'): void;
}>();

const photoPreview = ref<string | null>(props.initialPhoto ?? null);
const base64Preview = ref<string | null>(props.initialBase64 ?? null);
const blobPreview = ref<string | null>(props.initialBlob ?? null);

function onPhotoChange(event: Event) {
    const file = (event.target as HTMLInputElement).files?.[0] ?? null;
    props.form.photo = file;
    photoPreview.value = file
        ? URL.createObjectURL(file)
        : (props.initialPhoto ?? null);
}

function onBase64Change(event: Event) {
    const file = (event.target as HTMLInputElement).files?.[0] ?? null;
    props.form.base64 = file;
    base64Preview.value = file
        ? URL.createObjectURL(file)
        : (props.initialBase64 ?? null);
}

function onBlobChange(event: Event) {
    const file = (event.target as HTMLInputElement).files?.[0] ?? null;
    props.form.blob = file;
    blobPreview.value = file
        ? URL.createObjectURL(file)
        : (props.initialBlob ?? null);
}
</script>

<template>
    <form class="space-y-6" @submit.prevent="emit('submit')">
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <div class="space-y-2">
                <Label for="first_name">First Name</Label>
                <Input id="first_name" v-model="form.first_name" />
                <p
                    v-if="form.errors.first_name"
                    class="text-sm text-destructive"
                >
                    {{ form.errors.first_name }}
                </p>
            </div>
            <div class="space-y-2">
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

        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <div class="space-y-2">
                <Label for="email">Email</Label>
                <Input id="email" type="email" v-model="form.email" />
                <p v-if="form.errors.email" class="text-sm text-destructive">
                    {{ form.errors.email }}
                </p>
            </div>
            <div class="space-y-2">
                <Label for="phone">Phone</Label>
                <Input id="phone" v-model="form.phone" />
                <p v-if="form.errors.phone" class="text-sm text-destructive">
                    {{ form.errors.phone }}
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <div class="space-y-2">
                <Label for="student_id">Student ID</Label>
                <Input id="student_id" v-model="form.student_id" />
                <p
                    v-if="form.errors.student_id"
                    class="text-sm text-destructive"
                >
                    {{ form.errors.student_id }}
                </p>
            </div>
            <div class="space-y-2">
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

        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <div class="space-y-2">
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
            <div class="space-y-2">
                <Label for="status">Status</Label>
                <Select v-model="form.status">
                    <SelectTrigger id="status" class="w-full">
                        <SelectValue placeholder="Select a status" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectGroup>
                            <SelectItem value="active">Active</SelectItem>
                            <SelectItem value="inactive">Inactive</SelectItem>
                            <SelectItem value="graduated">Graduated</SelectItem>
                        </SelectGroup>
                    </SelectContent>
                </Select>
                <p v-if="form.errors.status" class="text-sm text-destructive">
                    {{ form.errors.status }}
                </p>
            </div>
        </div>

        <div class="space-y-2">
            <Label for="photo">Photo</Label>
            <div class="flex items-center gap-4">
                <img
                    v-if="photoPreview"
                    :src="photoPreview"
                    class="h-16 w-16 rounded-full border object-cover"
                />
                <div
                    v-else
                    class="flex h-16 w-16 items-center justify-center rounded-full border bg-muted"
                >
                    <span class="text-xs text-muted-foreground">None</span>
                </div>
                <Input
                    id="photo"
                    type="file"
                    accept="image/*"
                    @change="onPhotoChange"
                    class="max-w-[250px]"
                />
            </div>
            <p v-if="form.errors.photo" class="text-sm text-destructive">
                {{ form.errors.photo }}
            </p>
        </div>

        <!-- Form Upload Image Base 64 -->
        <div>
            <div>
                <Label for="base64">Base 64</Label>
                <Input
                    id="base64"
                    type="file"
                    accept="image/*"
                    @change="onBase64Change"
                    class="max-w-[250px]"
                />
                <!-- Preview Base 64 Image -->
                <img
                    v-if="base64Preview"
                    :src="base64Preview"
                    class="h-16 w-16 rounded-full border object-cover"
                />
                <div
                    v-else
                    class="flex h-16 w-16 items-center justify-center rounded-full border bg-muted"
                >
                    <span class="text-xs text-muted-foreground">None</span>
                </div>
            </div>
            <p v-if="form.errors.base64" class="text-sm text-destructive">
                {{ form.errors.base64 }}
            </p>
        </div>

        <!-- Form Upload Image Blob -->
        <div>
            <div>
                <Label for="blob">Blob</Label>
                <Input
                    id="blob"
                    type="file"
                    accept="image/*"
                    @change="onBlobChange"
                    class="max-w-[250px]"
                />
                <!-- Preivew Blob Image -->
                <img
                    v-if="blobPreview"
                    :src="blobPreview"
                    class="h-16 w-16 rounded-full border object-cover"
                />
                <div
                    v-else
                    class="flex h-16 w-16 items-center justify-center rounded-full border bg-muted"
                >
                    <span class="text-xs text-muted-foreground">None</span>
                </div>
            </div>
            <p v-if="form.errors.blob" class="text-sm text-destructive">
                {{ form.errors.blob }}
            </p>
        </div>

        <div class="pt-2">
            <Button type="submit" :disabled="form.processing">
                {{ submitText ?? 'Save' }}
            </Button>
        </div>
    </form>
</template>
