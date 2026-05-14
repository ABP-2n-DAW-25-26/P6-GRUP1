<script setup lang="ts">
import { Form } from '@inertiajs/vue3';
import { ref } from 'vue';
import Map from '@/components/AddLocationsMap.vue'
import { store } from '@/routes/interestpoint';

defineEmits(['location-selected'])
// Guarda la imatge seleccionada
const preview = ref<string | null>(null)
const handleFileChange = (event: Event) => {
  const input = event.target as HTMLInputElement

  if (input.files && input.files[0]) {
    // Crear URL temporal 
    preview.value = URL.createObjectURL(input.files[0])
  }
}

const latitude = ref('')
const longitude = ref('')

const setInterestPointLocation = (coords: { latitude: number, longitude: number }) => {
  latitude.value = coords.latitude.toString()
  longitude.value = coords.longitude.toString()
  console.log('coords seleccionades', latitude.value, longitude.value)
}

</script>


<template>
  <div class="min-h-screen bg-gray-100 dark:bg-gray-900 flex items-center justify-center p-4">
    <div class="w-full max-w-md">

      <div class="mb-6 text-center">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Crea una nova activitat</h1>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
          Completa la informació per crear una nova activitat
        </p>
      </div>

      <!-- Card -->
      <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-4">
        <Form :action="store()" method="post" class="space-y-5">
          <!-- Títol -->
          <div>
            <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Títol</label>
            <input type="text" name="title" placeholder="Punt d'interes..."
              class="mt-1 w-full px-3 py-2 text-sm border rounded-md focus:outline-none focus:ring-2 focus:ring-teal-400 dark:bg-gray-900 dark:border-gray-700 dark:text-white" />
          </div>

          <!-- Descripció -->
          <div>
            <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Descripció</label>
            <textarea name="description" rows="3" placeholder="Explica l'activitat aquí..."
              class="mt-1 w-full px-3 py-2 text-sm border rounded-md bg-gray-50 dark:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-teal-400 dark:border-gray-700 dark:text-white"></textarea>
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
          <!-- Imatge -->
          <div>
            <label class="mb-3 block text-sm font-medium text-gray-900 dark:text-gray-300">
              Imatge
            </label>
            <label
              class="flex flex-col items-center justify-center w-full h-40 border-2 border-dashed border-teal-300 rounded-2xl cursor-pointer hover:border-teal-500 hover:bg-teal-50 transition">
              <span class="text-sm text-gray-600">Fes clic per pujar una imatge</span>
              <input type="file" name="file" placeholder="" class="hidden" @change="handleFileChange" />
            </label>
            <!-- Preview -->
            <div v-if="preview" class="mt-4">
              <img :src="preview" alt="Preview" class="w-full h-40 object-contain rounded-xl" />
            </div>
          </div>

          <div class="w-full h-80 rounded-lg overflow-hidden">
            <h1 class="text-xl font-bold mb-4">Mapa</h1>
            <Map @location-selected="setInterestPointLocation" />
            <input type="hidden" name="latitude" v-model="latitude" />
            <input type="hidden" name="longitude" v-model="longitude" />
          </div>

          <!-- Botó enviar -->
          <div class="flex gap-3 pt-2 w-full">
            <button type="button" class="flex-1 py-2 rounded-md border border-gray-300 dark:border-gray-600 text-sm">
              Cancel·lar
            </button>
            <button type="submit" class="flex-1 py-2 rounded-md bg-teal-400 hover:bg-teal-300 text-sm font-semibold">
              Crear Activitat
            </button>
          </div>
        </Form>
      </div>
    </div>
  </div>
</template>