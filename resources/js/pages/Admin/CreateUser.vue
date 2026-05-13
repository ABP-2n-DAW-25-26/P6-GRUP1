<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { store } from '@/routes/admin';

const form = useForm({
    name: '',
    email: '',
    password: '',
    role: '',
});

const submit = () => {
    form.post(store().url);
};
</script>

<template>
    <div class="flex min-h-screen flex-col bg-white">
        <!-- info -->
        <div class="flex items-center gap-2 border-b border-gray-100 px-8 py-4">
            <span
                class="text-xs font-medium tracking-widest text-gray-300 uppercase"
                >Administració</span
            >
            <span class="text-gray-200">/</span>
            <span
                class="text-xs font-medium tracking-widest text-gray-400 uppercase"
                >Usuaris</span
            >
        </div>

        <div class="flex flex-1 flex-col lg:flex-row">
            <!-- sidebar -->
            <aside
                class="flex w-full flex-col gap-10 border-b border-gray-100 px-8 py-12 lg:w-72 lg:border-r lg:border-b-0"
            >
                <div>
                    <div
                        class="mb-4 flex h-11 w-11 items-center justify-center rounded-xl bg-gray-100 text-base font-semibold text-gray-500 uppercase"
                    >
                        {{ form.name?.charAt(0) || '?' }}
                    </div>
                    <p class="text-sm font-medium text-gray-800">
                        {{ form.name || '—' }}
                    </p>
                    <p class="mt-0.5 text-xs text-gray-400">
                        {{ form.email || '—' }}
                    </p>
                    <span
                        class="mt-2 inline-block rounded-full bg-gray-100 px-2 py-0.5 text-xs text-gray-400"
                    >
                        {{
                            form.role === 'admin'
                                ? 'Admin'
                                : form.role === 'user'
                                  ? 'Usuari'
                                  : '—'
                        }}
                    </span>
                </div>

                <div class="border-t border-gray-100" />

                <p class="text-xs leading-relaxed text-gray-300">
                    Completa les dades per crear un nou usuari.
                </p>
            </aside>

            <!-- form -->
            <main
                class="flex flex-1 items-start justify-center px-8 py-12 sm:px-12 lg:justify-start lg:px-20"
            >
                <div class="w-full max-w-md space-y-7">
                    <div>
                        <h1 class="text-lg font-semibold text-gray-900">
                            Nou usuari
                        </h1>
                    </div>

                    <div class="space-y-5">
                        <!-- nom -->
                        <div class="space-y-1.5">
                            <label
                                class="text-xs font-medium tracking-wide text-gray-400 uppercase"
                                >Nom</label
                            >
                            <input
                                v-model="form.name"
                                type="text"
                                placeholder="Nom complet"
                                class="w-full rounded-lg border border-transparent bg-gray-50 px-3.5 py-2.5 text-sm text-gray-800 transition outline-none hover:bg-gray-100 focus:border-gray-300 focus:bg-white"
                            />
                        </div>

                        <!-- email -->
                        <div class="space-y-1.5">
                            <label
                                class="text-xs font-medium tracking-wide text-gray-400 uppercase"
                                >Correu</label
                            >
                            <input
                                v-model="form.email"
                                type="email"
                                placeholder="correu@exemple.com"
                                class="w-full rounded-lg border border-transparent bg-gray-50 px-3.5 py-2.5 text-sm text-gray-800 transition outline-none hover:bg-gray-100 focus:border-gray-300 focus:bg-white"
                            />
                        </div>

                        <!-- password -->
                        <div class="space-y-1.5">
                            <label
                                class="text-xs font-medium tracking-wide text-gray-400 uppercase"
                                >Password</label
                            >
                            <input
                                v-model="form.password"
                                type="password"
                                placeholder="********"
                                class="w-full rounded-lg border border-transparent bg-gray-50 px-3.5 py-2.5 text-sm text-gray-800 transition outline-none hover:bg-gray-100 focus:border-gray-300 focus:bg-white"
                            />
                        </div>

                        <!-- rol -->
                        <div class="space-y-1.5">
                            <label
                                class="text-xs font-medium tracking-wide text-gray-400 uppercase"
                                >Rol</label
                            >
                            <div class="relative">
                                <select
                                    v-model="form.role"
                                    class="w-full cursor-pointer appearance-none rounded-lg border border-transparent bg-gray-50 px-3.5 py-2.5 text-sm text-gray-800 transition outline-none hover:bg-gray-100 focus:border-gray-300 focus:bg-white"
                                >
                                    <option value="">Selecciona rol</option>
                                    <option value="student">Student</option>
                                    <option value="teacher">Teacher</option>
                                </select>

                                <div
                                    class="pointer-events-none absolute inset-y-0 right-3 flex items-center"
                                >
                                    <svg
                                        class="h-3.5 w-3.5 text-gray-400"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="2"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M19 9l-7 7-7-7"
                                        />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- accions -->
                    <div class="flex items-center justify-between pt-2">
                        <button
                            type="button"
                            :disabled="form.processing"
                            @click="submit"
                            class="inline-flex items-center gap-2 rounded-lg bg-teal-600 px-5 py-2.5 text-xs font-semibold text-white transition hover:bg-gray-700 disabled:opacity-40"
                        >
                            <svg
                                v-if="form.processing"
                                class="h-3.5 w-3.5 animate-spin"
                                fill="none"
                                viewBox="0 0 24 24"
                            >
                                <circle
                                    cx="12"
                                    cy="12"
                                    r="10"
                                    stroke="currentColor"
                                    stroke-width="4"
                                />
                            </svg>

                            {{ form.processing ? 'Creant...' : 'Crear usuari' }}
                        </button>
                    </div>
                </div>
            </main>
        </div>
    </div>
</template>
