<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { update } from '@/routes/admin';

const props = defineProps<{
  user: any
}>();

const form = useForm({
  name: props.user.name,
  email: props.user.email,
  role: props.user.role,
});

const submit = () => {
  form.put(update(props.user.id).url);
};
</script>

<template>
  <div class="max-w-2xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">Editar usuari</h1>

    <form @submit.prevent="submit" class="space-y-4">

      <div>
        <label>Nom</label>
        <input v-model="form.name" class="w-full border rounded p-2" />
      </div>

      <div>
        <label>Email</label>
        <input v-model="form.email" class="w-full border rounded p-2" />
      </div>

      <div>
        <label>Rol</label>
        <select v-model="form.role" class="w-full border rounded p-2">
          <option value="student">Student</option>
          <option value="admin">Admin</option>
        </select>
      </div>

      <button
        type="submit"
        class="bg-teal-600 text-white px-4 py-2 rounded"
      >
        Guardar canvis
      </button>

    </form>
  </div>
</template>