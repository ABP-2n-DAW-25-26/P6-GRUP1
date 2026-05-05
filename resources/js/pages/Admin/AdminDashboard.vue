<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { edit, destroy, show, create, } from '@/routes/admin';
import AppLayout from '@/layouts/AppLayout.vue';
import { Plus, Eye, Pencil, Trash2 } from 'lucide-vue-next';
import Swal from 'sweetalert2';

defineProps<{
  users: Array<any>
}>();

defineOptions({ layout: AppLayout });

// eliminar user
const deleteUser = async (id: number) => {
  const result = await Swal.fire({
    title: 'Eliminar usuari?',
    text: 'Aquesta acció no es pot desfer.',

    showCancelButton: true,
    confirmButtonText: 'Eliminar',
    cancelButtonText: 'Cancel·lar',

    icon: undefined,
    background: '#fff',
    color: '#111827',
    buttonsStyling: false,

    customClass: {
      popup: 'rounded-xl border border-gray-100',
      title: 'text-base font-medium',
      htmlContainer: 'text-sm text-gray-400',
      confirmButton:'text-red-600 font-medium px-3 py-2 rounded-lg transition hover:bg-red-50 hover:text-red-700 focus:outline-none',
      cancelButton:'text-gray-500 px-3 py-2 rounded-lg transition hover:bg-gray-100 hover:text-gray-700 ml-2 focus:outline-none'
    }
  });

  if (result.isConfirmed) {
    router.delete(destroy(id), {
      onSuccess: () => {
        Swal.fire({
          title: 'Eliminat',
          timer: 1200,
          showConfirmButton: false,
          background: '#fff',
          color: '#111827',
          customClass: {
            popup: 'rounded-xl border border-gray-100'
          }
        });
      }
    });
  }
};

</script>
<template>
  <div class="mx-auto flex h-full w-full max-w-6xl flex-1 flex-col gap-6 p-6">

    <div class="flex items-center justify-between">
      <h1 class="text-3xl font-bold text-hp-text">Llista usuaris</h1>

      <Link
        :href="create()"
        class="inline-flex items-center gap-2 rounded-xl bg-hp-primary px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:opacity-90 active:scale-95">
        + Nou usuari
    </Link>
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
                <Link :href="show(user.id)"
                  class="rounded-lg p-2 text-hp-text-dim transition hover:bg-gray-100 hover:text-hp-text" title="Veure">
                  <Eye class="w-4 h-4" />
                </Link>
                <Link :href="edit(user.id)"
                  class="rounded-lg p-2 text-hp-text-dim transition hover:bg-gray-100 hover:text-hp-text"
                  title="Editar">
                  <Pencil class="w-4 h-4" />
                </Link>
                <button @click="deleteUser(user.id)"
                  class="rounded-lg p-2 text-hp-text-dim transition hover:bg-red-50 hover:text-hp-red" title="Eliminar">
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