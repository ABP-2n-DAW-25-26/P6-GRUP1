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
        <div class="max-w-6xl mx-auto py-12 px-4">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Usuarios</h1>
                <Link href="/users/create" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Agregar usuarios
                </Link>
            </div>

            <div class="bg-white rounded-lg shadow overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                Nombre
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                Apellido
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                Email
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                Rol
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="user in users" :key="user.id" class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ user.name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ user.surname }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                {{ user.email }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span :class="['px-3 py-1 rounded-full text-xs font-medium', 
                                    user.role === 'admin' ? 'bg-red-100 text-red-800' : 
                                    user.role === 'teacher' ? 'bg-blue-100 text-blue-800' : 
                                    'bg-green-100 text-green-800'
                                ]">
                                    {{ user.role }}
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div v-if="users.length === 0" class="text-center py-8">
                    <p class="text-gray-500">No hay usuarios registrados</p>
                </div>
            </div>
        </div>
    </div>
</template>
