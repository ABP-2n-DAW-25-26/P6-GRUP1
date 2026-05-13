<script setup lang="ts">
import { Form } from '@inertiajs/vue3';
import { ref } from 'vue';
import { update } from '@/routes/exchange';

const props = defineProps<{ exchange?: Record<string, any> }>();

function formatForDatetimeLocal(dateStr: string | undefined) {
  if (!dateStr) {
return '';
}

  const d = new Date(dateStr);

  if (Number.isNaN(d.getTime())) {
return '';
}

  const pad = (n: number) => String(n).padStart(2, '0');
  const yyyy = d.getFullYear();
  const mm = pad(d.getMonth() + 1);
  const dd = pad(d.getDate());
  const hh = pad(d.getHours());
  const min = pad(d.getMinutes());

  return `${yyyy}-${mm}-${dd}T${hh}:${min}`;
}

const selectedColor = ref(props.exchange?.color ?? '#10b981');

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

const title = ref(props.exchange?.title ?? '');
const origin = ref(props.exchange?.origin ?? '');
const destiny = ref(props.exchange?.destiny ?? '');
const start_date = ref(formatForDatetimeLocal(props.exchange?.start_date));
const end_date = ref(formatForDatetimeLocal(props.exchange?.end_date));

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Editar Intercanvi',
                // href: schedule(),
            },
        ],
    },
});
</script>


<template>
  <div class="flex items-center p-4 w-full">
    <div class="w-full max-w-lg mx-auto">

      <!-- Card -->
      <p class="font-hp text-6xl text-hp-primary">Intercanvi</p>

      <div class="bg-white dark:bg-gray-800 rounded-2xl  p-4">
        <Form :action="update(props.exchange?.id)" method="put" class="space-y-5">
          <!-- Títol -->
          <div>
            <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Títol</label>
            <input v-model="title" type="text" name="title" placeholder="Escandinavia-2026"
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
            <input v-model="origin" type="text" name="origin" placeholder="Figueres"
              class=" mt-1 w-full px-3 py-2 text-sm border rounded-md focus:outline-none focus:ring-2 focus:ring-teal-400 dark:bg-gray-900 dark:border-gray-700 dark:text-white" />
          </div>

          <!-- Desti -->
          <div>
            <label class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Desti</label>
            <input v-model="destiny" type="text" name="destiny" placeholder="Italia"
              class="mt-1 w-full px-3 py-2 text-sm border rounded-md focus:outline-none focus:ring-2 focus:ring-teal-400 dark:bg-gray-900 dark:border-gray-700 dark:text-white" />
          </div>

          <!-- Dates -->
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <div>
              <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Comença</label>
              <input v-model="start_date" type="datetime-local" name="start_date"
                class="mt-1 w-full px-3 py-2 rounded-md border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-sm focus:outline-none focus:ring-2 focus:ring-teal-400" />
            </div>

            <div>
              <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Acaba</label>
              <input v-model="end_date" type="datetime-local" name="end_date"
                class="mt-1 w-full px-3 py-2 rounded-md border border-gray-200 dark:border-gray-700  bg-gray-50 dark:bg-gray-900 text-sm focus:outline-none focus:ring-2 focus:ring-teal-400" />
            </div>
          </div>

          <!-- Botó enviar -->
          <div class="flex gap-3 pt-2 w-full lg:mt-20">
            <input type="button" onclick="history.back()" value="Cancel·lar" class="flex-1 py-2 rounded-md border hover:cursor-pointer border-gray-300 dark:border-gray-600 text-sm">
            <button type="submit"
              class="flex-1 py-2 rounded-md bg-teal-400 hover:bg-teal-300 hover:cursor-pointer text-sm font-semibold">
                Actualitzar intercanvi
            </button>
          </div>
        </Form>
      </div>
    </div>
  </div>
</template>