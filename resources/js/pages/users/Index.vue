<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

interface User {
    id: number;
    name: string;
    surname: string;
    email: string;
    role: string;
}

interface Props {
    users: User[];
}

defineProps<Props>();
</script>

<template>
    <div class="min-h-screen bg-gray-50">
        <div class="mx-auto max-w-6xl px-4 py-12">
            <div class="mb-8 flex items-center justify-between">
                <h1 class="text-3xl font-bold text-gray-900">Usuarios</h1>
                <Link
                    href="/users/create"
                    class="rounded-lg bg-blue-600 px-4 py-2 text-white hover:bg-blue-700"
                >
                    Agregar usuarios
                </Link>
            </div>

            <div class="overflow-hidden rounded-lg bg-white shadow">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium tracking-wider text-gray-700 uppercase"
                            >
                                Nombre
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium tracking-wider text-gray-700 uppercase"
                            >
                                Apellido
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium tracking-wider text-gray-700 uppercase"
                            >
                                Email
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium tracking-wider text-gray-700 uppercase"
                            >
                                Rol
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        <tr
                            v-for="user in users"
                            :key="user.id"
                            class="hover:bg-gray-50"
                        >
                            <td
                                class="px-6 py-4 text-sm whitespace-nowrap text-gray-900"
                            >
                                {{ user.name }}
                            </td>
                            <td
                                class="px-6 py-4 text-sm whitespace-nowrap text-gray-900"
                            >
                                {{ user.surname }}
                            </td>
                            <td
                                class="px-6 py-4 text-sm whitespace-nowrap text-gray-600"
                            >
                                {{ user.email }}
                            </td>
                            <td class="px-6 py-4 text-sm whitespace-nowrap">
                                <span
                                    :class="[
                                        'rounded-full px-3 py-1 text-xs font-medium',
                                        user.role === 'admin'
                                            ? 'bg-red-100 text-red-800'
                                            : user.role === 'teacher'
                                              ? 'bg-blue-100 text-blue-800'
                                              : 'bg-green-100 text-green-800',
                                    ]"
                                >
                                    {{ user.role }}
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div v-if="users.length === 0" class="py-8 text-center">
                    <p class="text-gray-500">No hay usuarios registrados</p>
                </div>
            </div>
        </div>
    </div>
</template>
