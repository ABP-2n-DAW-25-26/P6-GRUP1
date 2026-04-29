<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { Plus, Eye, Pencil, Trash2 } from 'lucide-vue-next';

defineProps<{
  users: Array<any>
}>();

defineOptions({ layout: AppLayout });

</script>
<template>
  <div class="mx-auto flex h-full w-full max-w-6xl flex-1 flex-col gap-6 p-6">

    <div class="flex items-center justify-between">
      <h1 class="text-3xl font-bold text-hp-text">Llista usuaris</h1>

      <button
        class="inline-flex items-center gap-2 rounded-xl bg-hp-primary px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:opacity-90 active:scale-95">
        + Nou usuari
      </button>
    </div>

    <!-- Taula -->
    <div class="w-full overflow-x-auto rounded-xl border border-gray-200 bg-white shadow-sm">
      <table class="min-w-full text-sm">
        <thead>
          <tr class="border-b border-gray-100 bg-gray-50">
            <th class="px-8 py-4 text-left text-xs font-semibold uppercase tracking-widest text-gray-400">
              Usuari
            </th>
            <th class="px-4 py-4 text-left text-xs font-semibold uppercase tracking-widest text-gray-400">
              Intercanvi
            </th>
            <th class="px-4 py-4 text-left text-xs font-semibold uppercase tracking-widest text-gray-400">
              Rol
            </th>
            <th class="px-4 py-4 text-left text-xs font-semibold uppercase tracking-widest text-gray-400">
              Estat
            </th>
            <th class="px-8 py-4 text-right text-xs font-semibold uppercase tracking-widest text-gray-400">
              Accions
            </th>
          </tr>
        </thead>

        <tbody>
          <tr v-for="user in users" :key="user.id" class="border-b border-gray-100 hover:bg-gray-50/60">
            <!-- nom -->
            <td class="px-8 py-6 font-semibold text-hp-text">
              {{ user.name }}
            </td>
            <!-- intercanvi -->
            <td class="px-4 py-6 text-hp-text-dim whitespace-nowrap">
              {{ user.exchanges?.[0]?.title ?? '-' }}
            </td>
            <!-- rol -->
            <td class="px-4 py-6 text-hp-text-dim whitespace-nowrap">
              {{ user.role }}
            </td>
            <td class="px-4 py-6">
              <span
                class="inline-flex items-center rounded-full px-4 py-1.5 text-xs font-semibold bg-green-100 text-green-700">
                actiu
              </span>
            </td>
            <td class="px-8 py-6">
              <div class="flex items-center justify-end gap-2">
                <Link class="rounded-lg p-2 text-hp-text-dim transition hover:bg-gray-100 hover:text-hp-text"
                  title="Veure">
                  <Eye class="w-4 h-4" />
                </Link>
                <Link class="rounded-lg p-2 text-hp-text-dim transition hover:bg-gray-100 hover:text-hp-text"
                  title="Editar">
                  <Pencil class="w-4 h-4" />
                </Link>
                <button class="rounded-lg p-2 text-hp-text-dim transition hover:bg-red-50 hover:text-hp-red"
                  title="Eliminar">
                  <Trash2 class="w-4 h-4" />
                </button>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

  </div>
</template>