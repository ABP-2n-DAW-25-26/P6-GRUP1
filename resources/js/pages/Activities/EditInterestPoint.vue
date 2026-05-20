<script setup lang="ts">
import { Form, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import Map from '@/components/AddLocationsMap.vue';
import { update } from '@/routes/exchange/interestpoint';

interface InterestPoint {
    id: number;
    title: string;
    description?: string;
    start_date?: string;
    end_date?: string;
    latitude?: number;
    longitude?: number;
    exchange_id: number;
}

const props = defineProps<{
    activity: InterestPoint;
}>();

const form = ref({
    title: props.activity.title ?? '',
    description: props.activity.description ?? '',
    start_date: props.activity.start_date ?? '',
    end_date: props.activity.end_date ?? '',
});

const preview = ref<string | null>(null);

const handleFileChange = (event: Event) => {
    const input = event.target as HTMLInputElement;
    if (input.files && input.files[0]) {
        preview.value = URL.createObjectURL(input.files[0]);
    }
};

const latitude = ref(props.activity.latitude?.toString() ?? '');
const longitude = ref(props.activity.longitude?.toString() ?? '');

const setInterestPointLocation = (coords: {
    latitude: number;
    longitude: number;
}) => {
    latitude.value = coords.latitude.toString();
    longitude.value = coords.longitude.toString();
};
</script>

<template>
    <div class="flex min-h-screen items-center justify-center bg-gray-100 p-4 dark:bg-gray-900">
        <div class="w-full max-w-md">

            <!-- HEADER -->
            <div class="mb-6 text-center">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                    Edita punt d'interès
                </h1>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Modifica la informació del punt d'interès
                </p>
            </div>

            <!-- CARD -->
            <div class="rounded-2xl bg-white p-4 shadow-lg dark:bg-gray-800">

                <Form
                    :action="update({
                        exchange: activity.exchange_id,
                        interestpoint: activity.id
                    })"
                    method="put"
                    class="space-y-5"
                >

                    <!-- TÍTOL -->
                    <div>
                        <label class="text-sm font-medium text-gray-700 dark:text-gray-300">
                            Títol
                        </label>
                        <input
                            type="text"
                            name="title"
                            v-model="form.title"
                            class="mt-1 w-full rounded-md border px-3 py-2 text-sm dark:bg-gray-900 dark:text-white"
                        />
                    </div>

                    <!-- DESCRIPCIÓ -->
                    <div>
                        <label class="text-sm font-medium text-gray-700 dark:text-gray-300">
                            Descripció
                        </label>
                        <textarea
                            name="description"
                            v-model="form.description"
                            class="mt-1 w-full rounded-md border px-3 py-2 text-sm dark:bg-gray-900 dark:text-white"
                        />
                    </div>

                    <!-- FECHAS -->
                    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                        <div>
                            <label class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                Inici
                            </label>
                            <input
                                type="datetime-local"
                                name="start_date"
                                v-model="form.start_date"
                                class="mt-1 w-full rounded-md border px-3 py-2 text-sm dark:bg-gray-900"
                            />
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                Fi
                            </label>
                            <input
                                type="datetime-local"
                                name="end_date"
                                v-model="form.end_date"
                                class="mt-1 w-full rounded-md border px-3 py-2 text-sm dark:bg-gray-900"
                            />
                        </div>
                    </div>

                    <!-- IMAGEN -->
                    <div>
                        <label class="text-sm font-medium text-gray-900 dark:text-gray-300">
                            Imatge
                        </label>

                        <label
                            class="flex h-40 w-full cursor-pointer flex-col items-center justify-center rounded-2xl border-2 border-dashed border-teal-300 transition hover:border-teal-500 hover:bg-teal-50"
                        >
                            <span class="text-sm text-gray-600">
                                Canvia la imatge
                            </span>

                            <input
                                type="file"
                                name="file"
                                class="hidden"
                                @change="handleFileChange"
                            />
                        </label>

                        <div v-if="preview" class="mt-4">
                            <img
                                :src="preview"
                                class="h-40 w-full rounded-xl object-contain"
                            />
                        </div>
                    </div>

                    <!-- MAPA -->
                    <div class="h-80 w-full overflow-hidden rounded-lg">
                        <h1 class="mb-4 text-xl font-bold">Mapa</h1>

                        <Map @location-selected="setInterestPointLocation" />

                        <input type="hidden" name="latitude" v-model="latitude" />
                        <input type="hidden" name="longitude" v-model="longitude" />
                    </div>

                    <!-- BOTONS -->
                    <div class="flex gap-3 pt-2">
                        <Link
                            :href="`/exchange/${activity.exchange_id}`"
                            class="flex-1 rounded-md border py-2 text-center text-sm"
                        >
                            Cancel·lar
                        </Link>

                        <button
                            type="submit"
                            class="flex-1 rounded-md bg-teal-400 py-2 text-sm font-semibold hover:bg-teal-300"
                        >
                            Guardar canvis
                        </button>
                    </div>

                </Form>
            </div>
        </div>
    </div>
</template>