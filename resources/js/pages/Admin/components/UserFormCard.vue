<script setup lang="ts">
const props = defineProps<{
    form: any;
    submitLabel: string;
    withPassword?: boolean;
}>();

const emit = defineEmits<{
    submit: [];
    change: [field: string, value: string];
}>();
</script>

<template>
    <div class="max-w-lg rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
        <div class="space-y-5">

            <!-- Nom -->
            <div class="space-y-1.5">
                <label class="text-xs font-semibold tracking-wide text-gray-400 uppercase">Nom</label>
                <input
                    :value="form.name"
                    type="text"
                    placeholder="Nom complet"
                    class="w-full rounded-lg border border-gray-200 bg-gray-50 px-3.5 py-2.5 text-sm text-hp-text outline-none transition hover:bg-gray-100 focus:border-hp-primary focus:bg-white focus:ring-0"
                    @input="emit('change', 'name', ($event.target as HTMLInputElement).value)"
                />
                <p v-if="props.form.errors.name" class="text-xs text-red-500">{{ props.form.errors.name }}</p>
            </div>

            <!-- Correu -->
            <div class="space-y-1.5">
                <label class="text-xs font-semibold tracking-wide text-gray-400 uppercase">Correu</label>
                <input
                    :value="form.email"
                    type="email"
                    placeholder="correu@exemple.com"
                    class="w-full rounded-lg border border-gray-200 bg-gray-50 px-3.5 py-2.5 text-sm text-hp-text outline-none transition hover:bg-gray-100 focus:border-hp-primary focus:bg-white focus:ring-0"
                    @input="emit('change', 'email', ($event.target as HTMLInputElement).value)"
                />
                <p v-if="props.form.errors.email" class="text-xs text-red-500">{{ props.form.errors.email }}</p>
            </div>

            <!-- Contrasenya -->
            <div v-if="withPassword" class="space-y-1.5">
                <label class="text-xs font-semibold tracking-wide text-gray-400 uppercase">Contrasenya</label>
                <input
                    :value="form.password"
                    type="password"
                    placeholder="********"
                    class="w-full rounded-lg border border-gray-200 bg-gray-50 px-3.5 py-2.5 text-sm text-hp-text outline-none transition hover:bg-gray-100 focus:border-hp-primary focus:bg-white focus:ring-0"
                    @input="emit('change', 'password', ($event.target as HTMLInputElement).value)"
                />
                <p v-if="props.form.errors.password" class="text-xs text-red-500">{{ props.form.errors.password }}</p>
            </div>

            <!-- Rol -->
            <div class="space-y-1.5">
                <label class="text-xs font-semibold tracking-wide text-gray-400 uppercase">Rol</label>
                <select
                    :value="form.role"
                    class="w-full rounded-lg border border-gray-200 bg-gray-50 px-3.5 py-2.5 text-sm text-hp-text outline-none transition hover:bg-gray-100 focus:border-hp-primary focus:bg-white"
                    @change="emit('change', 'role', ($event.target as HTMLSelectElement).value)"
                >
                    <option value="">Selecciona rol</option>
                    <option value="student">Student</option>
                    <option value="teacher">Teacher</option>
                    <option value="admin">Admin</option>
                </select>
                <p v-if="props.form.errors.role" class="text-xs text-red-500">{{ props.form.errors.role }}</p>
            </div>

        </div>

        <!-- Footer -->
        <div class="mt-6 flex items-center justify-between border-t border-gray-100 pt-5">
            <p v-if="props.form.wasSuccessful" class="text-xs text-green-600">Desat correctament.</p>
            <div v-else />
            <button
                type="button"
                :disabled="props.form.processing"
                @click="emit('submit')"
                class="inline-flex items-center gap-2 rounded-xl bg-hp-primary px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:opacity-90 active:scale-95 disabled:opacity-50"
            >
                {{ props.form.processing ? 'Desant...' : submitLabel }}
            </button>
        </div>
    </div>
</template>
