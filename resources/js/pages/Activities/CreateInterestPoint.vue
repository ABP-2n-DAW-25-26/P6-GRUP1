<script setup lang="ts">
import { Form } from '@inertiajs/vue3';
import { ref } from 'vue';
import Map from '@/components/AddLocationsMap.vue';
import { store } from '@/routes/exchange/interestpoint';

defineEmits(['location-selected']);
// Guarda la imatge seleccionada
const preview = ref<string | null>(null);
const handleFileChange = (event: Event) => {
    const input = event.target as HTMLInputElement;

    if (input.files && input.files[0]) {
        // Crear URL temporal
        preview.value = URL.createObjectURL(input.files[0]);
    }
};

const latitude = ref('');
const longitude = ref('');

defineProps<{
    exchangeId: number;
}>();

const setInterestPointLocation = (coords: {
    latitude: number;
    longitude: number;
}) => {
    latitude.value = coords.latitude.toString();
    longitude.value = coords.longitude.toString();
    console.log('coords seleccionades', latitude.value, longitude.value);
};
</script>

<template>
    <div class="flex min-h-screen items-center justify-center p-4">
        <div class="w-full max-w-md">
            <div class="mb-6 text-center">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                    Crea un punt d'interés
                </h1>

                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Completa la informació per crear una nova activitat
                </p>
            </div>

            <!-- Card -->
            <div>
                <Form
                    :action="store(exchangeId)"
                    method="post"
                    class="space-y-5"
                >
                    <!-- Títol -->
                    <div>
                        <label
                            class="text-sm font-medium text-gray-700 dark:text-gray-300"
                            >Títol</label
                        >
                        <input
                            type="text"
                            name="title"
                            placeholder="Punt d'interes..."
                            class="mt-1 w-full rounded-md border px-3 py-2 text-sm focus:ring-2 focus:ring-teal-400 focus:outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white"
                        />
                    </div>

                    <!-- Descripció -->
                    <div>
                        <label
                            class="text-sm font-medium text-gray-700 dark:text-gray-300"
                            >Descripció</label
                        >
                        <textarea
                            name="description"
                            rows="3"
                            placeholder="Explica l'activitat aquí..."
                            class="mt-1 w-full rounded-md border bg-gray-50 px-3 py-2 text-sm focus:ring-2 focus:ring-teal-400 focus:outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white"
                        ></textarea>
                    </div>

                    <!-- Dates -->
                    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                        <div>
                            <label
                                class="text-sm font-medium text-gray-700 dark:text-gray-300"
                                >Comença</label
                            >
                            <input
                                type="datetime-local"
                                name="start_date"
                                class="mt-1 w-full rounded-md border border-gray-200 bg-gray-50 px-3 py-2 text-sm focus:ring-2 focus:ring-teal-400 focus:outline-none dark:border-gray-700 dark:bg-gray-900"
                            />
                        </div>

                        <div>
                            <label
                                class="text-sm font-medium text-gray-700 dark:text-gray-300"
                                >Acaba</label
                            >
                            <input
                                type="datetime-local"
                                name="end_date"
                                class="mt-1 w-full rounded-md border border-gray-200 bg-gray-50 px-3 py-2 text-sm focus:ring-2 focus:ring-teal-400 focus:outline-none dark:border-gray-700 dark:bg-gray-900"
                            />
                        </div>
                    </div>
                    <!-- Imatge -->
                    <div>
                        <label
                            class="mb-3 block text-sm font-medium text-gray-900 dark:text-gray-300"
                        >
                            Imatge
                        </label>
                        <label
                            class="flex h-40 w-full cursor-pointer flex-col items-center justify-center rounded-2xl border-2 border-dashed border-teal-300 transition hover:border-teal-500 hover:bg-teal-50"
                        >
                            <span class="text-sm text-gray-600"
                                >Fes clic per pujar una imatge</span
                            >
                            <input
                                type="file"
                                name="file"
                                placeholder=""
                                class="hidden"
                                @change="handleFileChange"
                            />
                        </label>
                        <!-- Preview -->
                        <div v-if="preview" class="mt-4">
                            <img
                                :src="preview"
                                alt="Preview"
                                class="h-40 w-full rounded-xl object-contain"
                            />
                        </div>
                    </div>

                    <div class="h-80 w-full overflow-hidden rounded-lg">
                        <h1 class="mb-4 text-xl font-bold">Mapa</h1>
                        <Map @location-selected="setInterestPointLocation" />
                        <input
                            type="hidden"
                            name="latitude"
                            v-model="latitude"
                        />
                        <input
                            type="hidden"
                            name="longitude"
                            v-model="longitude"
                        />
                    </div>

                    <!-- Botó enviar -->
                    <div class="flex w-full gap-3 pt-2">
                        <button
                            type="button"
                            class="flex-1 rounded-md border border-gray-300 py-2 text-sm dark:border-gray-600"
                        >
                            Cancel·lar
                        </button>
                        <button
                            type="submit"
                            class="flex-1 rounded-md bg-teal-400 py-2 text-sm font-semibold hover:bg-teal-300"
                        >
                            Crear Activitat
                        </button>
                    </div>
                </Form>
            </div>
        </div>
    </div>
</template>
