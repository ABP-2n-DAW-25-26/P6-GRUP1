<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import Map from '@/components/AddLocationsMap.vue';
import { store } from '@/routes/exchange/guidedactivity';

type GuidedLocationPayload = {
    name: string;
    description: string;
    latitude: string;
    longitude: string;
    order: number;
};

const props = defineProps<{
    exchangeId: number;
}>();

const form = useForm({
    title: '',
    description: '',
    start_date: '',
    end_date: '',
    file: null as File | null,
    locations: [
        {
            name: '',
            description: '',
            latitude: '',
            longitude: '',
            order: 1,
        },
    ] as GuidedLocationPayload[],
});

// Guarda la imatge seleccionada
const preview = ref<string | null>(null);
const handleFileChange = (event: Event) => {
    const input = event.target as HTMLInputElement;

    if (input.files && input.files[0]) {
        // Crear URL temporal
        preview.value = URL.createObjectURL(input.files[0]);
        form.file = input.files[0];
    }
};

const addLocation = () => {
    form.locations.push({
        name: '',
        description: '',
        latitude: '',
        longitude: '',
        order: form.locations.length + 1,
    });
};

const removeLocation = (index: number) => {
    form.locations.splice(index, 1);
    form.locations.forEach((location, idx) => {
        location.order = idx + 1;
    });
};

const setLocationCoords = (
    index: number,
    coords: { latitude: number; longitude: number },
) => {
    form.locations[index].latitude = coords.latitude.toString();
    form.locations[index].longitude = coords.longitude.toString();
};

const submit = () => {
    form.locations.forEach((location, idx) => {
        location.order = idx + 1;
    });

    form.post(store(props.exchangeId), {
        forceFormData: true,
    });
};
</script>

<template>
    <div
        class="flex min-h-screen items-center justify-center mt-5"
    >
        <div class="w-full max-w-md">
            <div class="mb-6 text-center">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                    Crea una nova activitat
                </h1>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Completa la informació per crear una nova activitat
                </p>
            </div>

            <!-- Card -->
            <div class="rounded-2xl p-4">
                <form @submit.prevent="submit" class="space-y-5">
                    <!-- Títol -->
                    <div>
                        <label
                            class="text-sm font-medium text-gray-700 dark:text-gray-300"
                            >Títol</label
                        >
                        <input
                            type="text"
                            v-model="form.title"
                            placeholder="Visita guiada..."
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
                            v-model="form.description"
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
                                v-model="form.start_date"
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
                                v-model="form.end_date"
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

                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <h2 class="text-sm font-semibold text-gray-900 dark:text-gray-200">
                                Localitzacions
                            </h2>
                            <button type="button" @click="addLocation"
                                class="rounded-md border border-teal-300 px-3 py-1 text-xs font-semibold text-teal-700 transition hover:border-teal-500 hover:text-teal-600">
                                Afegir parada
                            </button>
                        </div>

                        <div v-for="(location, index) in form.locations" :key="index"
                            class="rounded-xl border border-gray-200 bg-gray-50 p-4 dark:border-gray-700 dark:bg-gray-900">
                            <div class="mb-3 flex items-center justify-between">
                                <p class="text-sm font-semibold text-gray-800 dark:text-gray-200">
                                    Parada {{ index + 1 }}
                                </p>
                                <button v-if="form.locations.length > 1" type="button" @click="removeLocation(index)"
                                    class="text-xs font-semibold text-red-500 uppercase hover:text-red-600">
                                    Eliminar
                                </button>
                            </div>

                            <div class="space-y-3">
                                <div>
                                    <label class="text-xs font-medium text-gray-700 dark:text-gray-300">Nom</label>
                                    <input v-model="location.name" type="text" placeholder="Nom del punt"
                                        class="mt-1 w-full rounded-md border border-gray-200 bg-white px-3 py-2 text-sm focus:ring-2 focus:ring-teal-400 focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-white"/>
                                </div>
                                <div>
                                    <label class="text-xs font-medium text-gray-700 dark:text-gray-300">Descripció</label>
                                    <textarea v-model="location.description" rows="2" placeholder="Descripció del punt"
                                        class="mt-1 w-full rounded-md border border-gray-200 bg-white px-3 py-2 text-sm focus:ring-2 focus:ring-teal-400 focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                                    </textarea>
                                </div>
                                <div class="h-48 overflow-hidden rounded-lg">
                                    <Map @location-selected="(coords) => setLocationCoords(index, coords)"/>
                                </div>
                            </div>
                        </div>
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
                </form>
            </div>
        </div>
    </div>
</template>
