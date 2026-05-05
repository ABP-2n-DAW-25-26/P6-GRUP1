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
    <div class="min-h-screen bg-white flex flex-col">

        <!-- info -->
        <div class="border-b border-gray-100 px-8 py-4 flex items-center gap-2">
            <span class="text-xs text-gray-300 uppercase tracking-widest font-medium">Administració</span>
            <span class="text-gray-200">/</span>
            <span class="text-xs text-gray-400 uppercase tracking-widest font-medium">Usuaris</span>
        </div>

        <div class="flex flex-1 flex-col lg:flex-row">

            <!-- sidebar -->
            <aside
                class="w-full lg:w-72 border-b lg:border-b-0 lg:border-r border-gray-100 px-8 py-12 flex flex-col gap-10">
                <div>
                    <div
                        class="h-11 w-11 rounded-xl bg-gray-100 flex items-center justify-center text-gray-500 font-semibold text-base uppercase mb-4">
                        {{ form.name?.charAt(0) || '?' }}
                    </div>
                    <p class="text-sm font-medium text-gray-800">{{ form.name || '—' }}</p>
                    <p class="text-xs text-gray-400 mt-0.5">{{ form.email || '—' }}</p>
                    <span class="inline-block mt-2 text-xs text-gray-400 bg-gray-100 px-2 py-0.5 rounded-full">
                        {{ form.role === 'admin' ? 'Admin' : form.role === 'user' ? 'Usuari' : '—' }}
                    </span>
                </div>

                <div class="border-t border-gray-100" />

                <p class="text-xs text-gray-300 leading-relaxed">
                    Completa les dades per crear un nou usuari.
                </p>
            </aside>

            <!-- form -->
            <main class="flex-1 px-8 py-12 sm:px-12 lg:px-20 flex items-start justify-center lg:justify-start">
                <div class="w-full max-w-md space-y-7">

                    <div>
                        <h1 class="text-lg font-semibold text-gray-900">Nou usuari</h1>
                    </div>

                    <div class="space-y-5">

                        <!-- nom -->
                        <div class="space-y-1.5">
                            <label class="text-xs font-medium text-gray-400 uppercase tracking-wide">Nom</label>
                            <input v-model="form.name" type="text" placeholder="Nom complet" class="w-full px-3.5 py-2.5 text-sm text-gray-800 bg-gray-50 border border-transparent rounded-lg outline-none transition
                                focus:bg-white focus:border-gray-300 hover:bg-gray-100" />
                        </div>

                        <!-- email -->
                        <div class="space-y-1.5">
                            <label class="text-xs font-medium text-gray-400 uppercase tracking-wide">Correu</label>
                            <input v-model="form.email" type="email" placeholder="correu@exemple.com" class="w-full px-3.5 py-2.5 text-sm text-gray-800 bg-gray-50 border border-transparent rounded-lg outline-none transition
                                focus:bg-white focus:border-gray-300 hover:bg-gray-100" />
                        </div>

                        <!-- password -->
                        <div class="space-y-1.5">
                            <label class="text-xs font-medium text-gray-400 uppercase tracking-wide">Password</label>
                            <input v-model="form.password" type="password" placeholder="********" class="w-full px-3.5 py-2.5 text-sm text-gray-800 bg-gray-50 border border-transparent rounded-lg outline-none transition
                                focus:bg-white focus:border-gray-300 hover:bg-gray-100" />
                        </div>

                        <!-- rol -->
                        <div class="space-y-1.5">
                            <label class="text-xs font-medium text-gray-400 uppercase tracking-wide">Rol</label>
                            <div class="relative">
                                <select v-model="form.role" class="w-full px-3.5 py-2.5 text-sm text-gray-800 bg-gray-50 border border-transparent rounded-lg outline-none appearance-none transition cursor-pointer
                                    focus:bg-white focus:border-gray-300 hover:bg-gray-100">
                                    <option value="">Selecciona rol</option>
                                    <option value="student">Student</option>
                                    <option value="teacher">Teacher</option>
                                </select>

                                <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center">
                                    <svg class="w-3.5 h-3.5 text-gray-400" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- accions -->
                    <div class="flex items-center justify-between pt-2">

                        <button type="button" :disabled="form.processing" @click="submit" class="inline-flex items-center gap-2 bg-teal-600 hover:bg-gray-700 disabled:opacity-40
                            text-white text-xs font-semibold px-5 py-2.5 rounded-lg transition">

                            <svg v-if="form.processing" class="w-3.5 h-3.5 animate-spin" fill="none"
                                viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                            </svg>

                            {{ form.processing ? 'Creant...' : 'Crear usuari' }}
                        </button>
                    </div>

                </div>
            </main>
        </div>
    </div>
</template>