<script setup lang="ts">
import { computed, ref, watch } from 'vue';
import { Head } from '@inertiajs/vue3';
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';
import { dashboard } from '@/routes';
import StudentCard from '@/pages/StudentCard.vue';

const title = ref('Hello');

const increase = ref(0);

const increaseByOne = () => {
    increase.value++;
};

const decreaseByOne = () => {
    increase.value--;
};

const keyword = ref('');
const loggedIn = ref(false);
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
function changeLoggedIn() {
    loggedIn.value = !loggedIn.value;
}
const students = ref([
    {
        name: 'Ratanak',
        score: 90,
    },
    {
        name: 'John',
        score: 85,
    },
    {
        name: 'Jane',
        score: 80,
    },
]);

const firstName = ref('Ratanak');
const lastName = ref('Ieng');

const fullName = computed(() => {
    return `${firstName.value} ${lastName.value}`;
});

const keywords = ref('');

watch(keywords, () => {
    console.log(keywords.value);
});
</script>

<template>
    <Head :title="title" />

    <div
        class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
    >
        <input v-model="keywords" class="rounded border" />
        <h1>{{ fullName }}</h1>
        <p v-if="loggedIn">LoggedIn</p>
        <Button @click="changeLoggedIn">Toggle Logged In</Button>

        <div class="grid grid-cols-3">
            <div v-for="student in students" :key="student.name">
                {{ student.name }} {{ student.score }}
            </div>
        </div>
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div
                class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border"
            >
                <PlaceholderPattern />
            </div>
            <div
                class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border"
            >
                <PlaceholderPattern />
            </div>
            <div
                class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border"
            >
                <PlaceholderPattern />
            </div>
        </div>
        <div
            class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border"
        >
            <PlaceholderPattern />
        </div>
    </div>
</template>
