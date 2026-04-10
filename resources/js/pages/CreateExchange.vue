<script setup lang="ts">
import { Link, Form } from '@inertiajs/vue3';
import { store } from '@/routes/exchange';
</script>

<template>
  <div class="min-h-screen bg-gray-100 dark:bg-gray-900 flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        
      <div class="mb-6 text-center">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Crear un nou Intercanvi</h1>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
          Completa la informació per registrar un nou intercanvi
        </p>
      </div>

      <!-- Card -->
      <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 space-y-4">
        <Form :action="store()" method="post" class="space-y-4">
          <!-- Origen -->
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Origen</label>
            <input
              type="text"
              name="origin"
              placeholder="Figueres"
              class="w-full px-3 py-2 text-sm border rounded-md focus:outline-none focus:ring-2 focus:ring-teal-400 dark:bg-gray-900 dark:border-gray-700 dark:text-white"
            />
          </div>

          <!-- Desti -->
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Desti</label>
            <input
              type="text"
              name="destiny"
              placeholder="Italia"
              class="w-full px-3 py-2 text-sm border rounded-md focus:outline-none focus:ring-2 focus:ring-teal-400 dark:bg-gray-900 dark:border-gray-700 dark:text-white"
            />
          </div>

          <!-- Data d'inici -->
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Data d'inici</label>
            <input
              type="datetime-local"
              name="start_date"
              class="w-full px-3 py-2 text-sm border rounded-md focus:outline-none focus:ring-2 focus:ring-teal-400 dark:bg-gray-900 dark:border-gray-700 dark:text-white"
            />
          </div>

          <!-- Data de fi -->
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Data de fi</label>
            <input
              type="datetime-local"
              name="end_date"
              class="w-full px-3 py-2 text-sm border rounded-md focus:outline-none focus:ring-2 focus:ring-teal-400 dark:bg-gray-900 dark:border-gray-700 dark:text-white"
            />
          </div>

          <!-- Botó enviar -->
          <div>
            <button
              type="submit" class="w-full py-2 rounded-md bg-teal-400 hover:bg-teal-300 font-semibold shadow cursor-pointer">
              Crear Intercanvi
            </button>
          </div>
        </Form>
      </div>
    </div>
  </div>
</template>