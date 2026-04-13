<script setup lang="ts">
import { Link, Form } from '@inertiajs/vue3';
import { store } from '@/routes/exchange';
import { ref } from 'vue';

const selectedColor = ref('#10b981');

const colors = [
  '#a855f7',
  '#6366f1',
  '#60a5fa',
  '#22c55e',
  '#10b981',
  '#84cc16',
  '#facc15',
  '#fb923c',
  '#ef4444',
  '#ec4899',
];
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
      <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-4">
        <Form :action="store()" method="post" class="space-y-5">
          <!-- Títol -->
          <div>
            <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Títol</label>
            <input type="text" name="title" placeholder="Escandinavia-2026"
              class="mt-1 w-full px-3 py-2 text-sm border rounded-md focus:outline-none focus:ring-2 focus:ring-teal-400 dark:bg-gray-900 dark:border-gray-700 dark:text-white" />
          </div>
          <!-- Selector de color -->
          <div>
            <label class="text-sm font-medium text-gray-700 dark:text-gray-300">
              Color
            </label>
            <div class="flex gap-2 mt-2 flex-wrap">
              <button v-for="color in colors" :key="color" type="button" @click="selectedColor = color"
                class="w-8 h-8 sm:w-6 sm:h-6 rounded-full border-2 transition" :style="{ backgroundColor: color }"
                :class="selectedColor === color ? 'border-gray-900 dark:border-white scale-110' : 'border-transparent opacity-80'"></button>
            </div>
            <input type="hidden" name="color" :value="selectedColor" />
          </div>
          <!-- Origen -->
          <div>
            <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Origen</label>
            <input type="text" name="origin" placeholder="Figueres"
              class=" mt-1 w-full px-3 py-2 text-sm border rounded-md focus:outline-none focus:ring-2 focus:ring-teal-400 dark:bg-gray-900 dark:border-gray-700 dark:text-white" />
          </div>

          <!-- Desti -->
          <div>
            <label class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Desti</label>
            <input type="text" name="destiny" placeholder="Italia"
              class="mt-1 w-full px-3 py-2 text-sm border rounded-md focus:outline-none focus:ring-2 focus:ring-teal-400 dark:bg-gray-900 dark:border-gray-700 dark:text-white" />
          </div>

          <!-- Dates -->
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <div>
              <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Comença</label>
              <input type="datetime-local" name="start_date"
                class="mt-1 w-full px-3 py-2 rounded-md border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-sm focus:outline-none focus:ring-2 focus:ring-teal-400" />
            </div>

            <div>
              <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Acaba</label>
              <input type="datetime-local" name="end_date"
                class="mt-1 w-full px-3 py-2 rounded-md border border-gray-200 dark:border-gray-700  bg-gray-50 dark:bg-gray-900 text-sm focus:outline-none focus:ring-2 focus:ring-teal-400" />
            </div>
          </div>

          <!-- Botó enviar -->
          <div class="flex gap-3 pt-2 w-full">
            <button type="button" class="flex-1 py-2 rounded-md border border-gray-300 dark:border-gray-600 text-sm">
              Cancel·lar
            </button>
            <button type="submit"
              class="flex-1 py-2 rounded-md bg-teal-400 hover:bg-teal-300 text-sm font-semibold">
              Crear Intercanvi
            </button>
          </div>
        </Form>
      </div>
    </div>
  </div>
</template>