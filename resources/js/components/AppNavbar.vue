<script setup lang="ts">
import { computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import { login, schedule } from '@/routes';

const page = usePage();
const isLoggedIn = computed(() => !!page.props.auth?.user);
</script>

<template>
    <div class="fixed top-0 left-0 right-0 z-50 px-4 py-3">
        <nav class="relative flex items-center justify-between px-8 py-3 rounded-2xl shadow-sm border bg-white border-hp-border max-w-[95vw] mx-auto transition-colors">

            <Link href="/" class="flex items-center gap-3 no-underline">
                <span class="text-xl font-black tracking-widest text-hp-primary">HIPATIA</span>
            </Link>

            <div class="flex items-center gap-3">
                <Link
                    v-if="isLoggedIn"
                    :href="schedule()"
                    class="rounded-lg bg-hp-primary px-5 py-2 text-sm font-bold text-white hover:bg-hp-primary-dark transition-colors duration-200"
                >
                    Agenda
                </Link>
                <Link
                    v-else
                    :href="login()"
                    class="rounded-lg bg-hp-primary px-5 py-2 text-sm font-bold text-white hover:bg-hp-primary-dark transition-colors duration-200"
                >
                    Iniciar sessió
                </Link>
            </div>

        </nav>
    </div>
</template>
