<script setup lang="ts">
defineProps<{
    user: any
}>();

</script>

<template>
    <div class="min-h-screen w-full bg-gray-50 px-4 p-6 sm:px-6 lg:px-10 dark:bg-gray-900">

        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                    Perfil d'usuari
                </h1>
                <p class="text-sm text-gray-500">
                    Informació detallada de l'usuari
                </p>
            </div>

            <button class="w-full rounded-xl bg-teal-600 px-4 py-2 text-white hover:bg-teal-700 sm:w-auto">
                Editar usuari
            </button>
        </div>

        <!-- grid -->
        <div class="grid grid-cols-1 gap-6 xl:grid-cols-4">

            <div class="rounded-2xl bg-white p-6 shadow dark:bg-gray-800">

                <div class="flex flex-col items-center text-center">
                    <div
                        class="flex h-24 w-24 items-center justify-center rounded-full bg-gray-200 text-2xl font-bold text-gray-700 dark:bg-gray-700 dark:text-white">
                        {{ user.name.charAt(0) }}
                    </div>

                    <h2 class="mt-4 text-xl font-semibold text-gray-900 dark:text-white">
                        {{ user.name }}
                    </h2>

                    <p class="text-gray-500">{{ user.email }}</p>

                    <span class="mt-2 rounded-full bg-green-100 px-3 py-1 text-sm text-green-700">
                        {{ user.role }}
                    </span>
                </div>

                <div class="mt-6 border-t pt-4 text-sm text-gray-600 dark:text-gray-300">
                    <p><strong>ID:</strong> {{ user.id }}</p>
                    <p><strong>Usuari afegit:</strong>{{ new Date(user.created_at).toLocaleDateString() }}</p>
                </div>
            </div>

            <div class="space-y-6 xl:col-span-3">

                <!-- info usuari -->
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-3">

                    <div class="rounded-2xl bg-white p-4 shadow dark:bg-gray-800">
                        <p class="text-sm text-gray-500">Intercanvis</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">
                            {{ user.exchanges.length }}
                        </p>
                    </div>

                    <!-- cal afegir a al DB -->
                    <div class="rounded-2xl bg-white p-4 shadow dark:bg-gray-800">
                        <p class="text-sm text-gray-500">Estat</p>
                        <p class="text-2xl font-bold text-teal-600">
                            Active
                        </p>
                    </div>

                    <div class="rounded-2xl bg-white p-4 shadow dark:bg-gray-800">
                        <p class="text-sm text-gray-500">Rol</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">
                            {{ user.role }}
                        </p>
                    </div>

                </div>

                <!-- intercanvis info -->
                <div class="rounded-2xl bg-white p-6 shadow dark:bg-gray-800">
                    <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">
                        Intercanvis Recents
                    </h3>

                    <div v-if="user.exchanges.length > 0" class="space-y-3">
                        <div v-for="ex in user.exchanges" :key="ex.id"
                            class="flex items-center justify-between rounded-xl border p-3 dark:border-gray-700">
                            <div>
                                <p class="font-medium text-gray-900 dark:text-white">
                                    {{ ex.title }}
                                </p>
                                <p class="text-sm text-gray-500">
                                    {{ ex.origin }} - {{ ex.destiny }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>