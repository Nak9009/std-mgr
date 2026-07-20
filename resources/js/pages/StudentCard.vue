<script setup lang="ts">
import type { Student } from '@/types';

defineProps<Student>();
</script>

<template>
    <div class="rounded border p-2">
        <div>{{ student_id }}</div>
        <div>{{ first_name }} {{ last_name }}</div>
        <div>{{ email }}</div>
        <div>{{ phone }}</div>
        <div>{{ grade_level }}</div>
    </div>
</template>
