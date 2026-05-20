<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import Map from '@/components/AddLocationsMap.vue';
import OverviewMap from '@/components/LeafletMap.vue';
import { update } from '@/routes/exchange/gimcana';

type GimcanaLocationPayload = {
    name: string;
    description: string;
    statement: string;
    question_type: string;
    latitude: string;
    longitude: string;
    order: number;
    answers?: string[];
    correct_answer?: string;
};

interface Theme {
    id: number;
    name: string;
}

interface Exchange {
    id: number;
}

interface LocationRaw {
    id?: number | string;
    name: string;
    description?: string | null;
    statement?: string | null;
    question_type?: string | null;
    answer?: string | null;
    correct_answer?: string | null;
    latitude?: string | null;
    longitude?: string | null;
    order?: number | null;
}

const props = defineProps<{
    themes: Theme[];
    exchange: Exchange;
    gimcana: any;
    locations: LocationRaw[];
}>();

const initialLocations = props.locations.map((loc, idx) => {
    const question_type = loc.question_type ?? 'open';
    let answers: string[] = [''];

    if (question_type === 'multiple_choice') {
        try {
            answers = loc.answer ? JSON.parse(loc.answer) : [''];
            if (!Array.isArray(answers) || answers.length === 0) answers = [''];
        } catch (e) {
            answers = [''];
        }
    }

    return {
        name: loc.name ?? '',
        description: loc.description ?? '',
        statement: loc.statement ?? '',
        question_type: question_type,
        answers: answers,
        correct_answer: loc.correct_answer ?? '',
        latitude: loc.latitude ?? '',
        longitude: loc.longitude ?? '',
        order: loc.order ?? (idx + 1),
    } as GimcanaLocationPayload;
});

const form = ref({
    title: props.gimcana.title ?? '',
    description: props.gimcana.description ?? '',
    start_date: props.gimcana.start_date ?? '',
    end_date: props.gimcana.end_date ?? '',
    theme_id: props.gimcana.theme_id ?? '',
    type: 'gimcana',
    locations: initialLocations.length ? initialLocations : [
        {
            name: '',
            description: '',
            statement: '',
            question_type: 'open',
            answers: [''],
            correct_answer: '',
            latitude: '',
            longitude: '',
            order: 1,
        },
    ],
});

// ensure answers and order exist
form.value.locations.forEach((loc, idx) => {
    if (!loc.answers) loc.answers = [''];
    if (!('order' in loc) || loc.order === undefined || loc.order === null) loc.order = idx + 1;
});

// add new location
const addLocation = () => {
    form.value.locations.push({
        name: '',
        description: '',
        statement: '',
        question_type: 'open',
        answers: [''],
        correct_answer: '',
        latitude: '',
        longitude: '',
        order: form.value.locations.length + 1,
    });
};
const removeLocation = (index: number) => {
    form.value.locations.splice(index, 1);
};

const setLocationCoords = (
    index: number,
    coords: { latitude: number; longitude: number },
) => {
    form.value.locations[index].latitude = coords.latitude.toString();
    form.value.locations[index].longitude = coords.longitude.toString();
};

const addAnswer = (locationIndex: number) => {
    const loc = form.value.locations[locationIndex];
    if (!loc.answers) loc.answers = [''];
    loc.answers.push('');
};

const removeAnswer = (locationIndex: number, answerIndex: number) => {
    const location = form.value.locations[locationIndex];
    if (!location.answers) return;
    if (location.answers.length <= 1) {
        return;
    }

    const removedAnswer = location.answers[answerIndex];
    location.answers.splice(answerIndex, 1);

    if (location.correct_answer === removedAnswer) {
        location.correct_answer = '';
    }
};

const overviewMarkers = computed(() => {
    const result: { name: string; latitude: string; longitude: string }[] = [];

    for (let i = 0; i < form.value.locations.length; i++) {
        const loc = form.value.locations[i];

        if (loc.latitude && loc.longitude) {
            result.push({
                name: loc.name || 'Parada ' + (i + 1),
                latitude: loc.latitude,
                longitude: loc.longitude,
            });
        }
    }

    return result;
});

const updateGimcana = () => {
    const locations = form.value.locations.map((loc, index) => {
        const location: any = {
            name: loc.name,
            description: loc.description,
            statement: loc.statement,
            question_type: loc.question_type,
            latitude: loc.latitude,
            longitude: loc.longitude,
            order: index + 1,
        } as GimcanaLocationPayload;

        if (loc.question_type === 'multiple_choice') {
            location.answers = loc.answers;
            location.correct_answer = loc.correct_answer;
        }

        if (loc.question_type === 'true_false') {
            location.correct_answer = loc.correct_answer;
        }

        return location;
    });

    const payload = {
        title: form.value.title,
        description: form.value.description,
        start_date: form.value.start_date,
        end_date: form.value.end_date,
        theme_id: form.value.theme_id,
        type: form.value.type,
        locations: locations,
    };

    router.put(update.put({ exchange: props.exchange.id, gimcana: props.gimcana.id }), payload);
};
</script>

<template>
    <div class="min-h-screen">
        <div class="overflow-hidden">
            <div class="relative container pt-10">
                <div class="mb-8 flex flex-col gap-3">
                    <h1 class="text-3xl font-semibold text-hp-text">
                        Edita gimcana
                    </h1>
                </div>
            </div>
        </div>

        <form @submit.prevent="updateGimcana" class="grid gap-8 lg:grid-cols-3">
            <section class="space-y-6 lg:col-span-2">
                <div class="rounded-3xl border border-hp-border p-6 shadow-sm">
                    <h2 class="text-lg font-semibold text-hp-text">
                        Dades principals
                    </h2>
                    <div class="mt-5 grid gap-4 sm:grid-cols-2">
                        <div class="sm:col-span-2">
                            <label for="title">Titol</label>
                            <input
                                v-model="form.title"
                                type="text"
                                id="title"
                                placeholder="Titol de l'activitat"
                                class="mt-2 w-full rounded-xl border border-hp-border bg-hp-bg-card p-2 shadow-sm focus:ring-2 focus:ring-hp-primary/50 focus:outline-none"
                                required
                            />
                        </div>
                        <div class="sm:col-span-2">
                            <label for="description">Descripcio</label>
                            <textarea
                                v-model="form.description"
                                id="description"
                                rows="3"
                                placeholder="Descripcio de la gimcana"
                                class="mt-2 w-full rounded-xl border border-hp-border bg-hp-bg-card p-2 shadow-sm focus:ring-2 focus:ring-hp-primary/50 focus:outline-none"
                            ></textarea>
                        </div>
                        <div>
                            <label for="start_date">Data d'inici</label>
                            <input
                                v-model="form.start_date"
                                type="datetime-local"
                                id="start_date"
                                class="mt-2 w-full rounded-xl border border-hp-border bg-hp-bg-card p-2 shadow-sm focus:ring-2 focus:ring-hp-primary/50 focus:outline-none"
                            />
                        </div>
                        <div>
                            <label for="end_date">Data de fi</label>
                            <input
                                v-model="form.end_date"
                                type="datetime-local"
                                id="end_date"
                                class="mt-2 w-full rounded-xl border border-hp-border bg-hp-bg-card p-2 shadow-sm focus:ring-2 focus:ring-hp-primary/50 focus:outline-none"
                            />
                        </div>
                        <div class="sm:col-span-2">
                            <label for="theme_id">Tema</label>
                            <select
                                v-model="form.theme_id"
                                id="theme_id"
                                class="mt-2 w-full rounded-xl border border-hp-border bg-hp-bg-card p-2 shadow-sm focus:ring-2 focus:ring-hp-primary/50 focus:outline-none"
                            >
                                <option value="">Selecciona un tema</option>
                                <option
                                    v-for="theme in props.themes"
                                    :key="theme.id"
                                    :value="theme.id"
                                >
                                    {{ theme.name }}
                                </option>
                            </select>
                        </div>
                    </div>
                </div>

                <div
                    class="rounded-3xl border border-hp-border bg-hp-bg-card p-6 shadow-sm"
                >
                    <div
                        class="flex flex-wrap items-center justify-between gap-3"
                    >
                        <div>
                            <h2 class="text-lg font-semibold text-hp-text">
                                Parades
                            </h2>
                        </div>
                        <button
                            type="button"
                            @click="addLocation"
                            class="inline-flex items-center gap-2 rounded-full border-2 border-hp-primary-light bg-hp-primary px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:border-2 hover:border-hp-primary hover:bg-hp-primary-light"
                        >
                            <span class="text-lg">+</span>
                            Afegir parada
                        </button>
                    </div>

                    <div class="mt-6 space-y-5">
                        <div
                            v-for="(location, index) in form.locations"
                            :key="index"
                            class="rounded-2xl border border-hp-border bg-hp-bg-card p-5 shadow-sm"
                        >
                            <div
                                class="flex flex-wrap items-center justify-between gap-3"
                            >
                                <div class="flex items-center gap-3">
                                    <span
                                        class="flex h-9 w-9 items-center justify-center rounded-full bg-hp-primary text-sm font-semibold text-white"
                                    >
                                        {{ index + 1 }}
                                    </span>
                                    <div>
                                        <p class="text-hp-text">
                                            Parada {{ index + 1 }}
                                        </p>
                                    </div>
                                </div>
                                <button
                                    type="button"
                                    @click="removeLocation(index)"
                                    class="text-xs font-semibold tracking-wider text-red-500 uppercase hover:text-red-600"
                                >
                                    Eliminar
                                </button>
                            </div>

                            <div class="mt-4 grid gap-4 lg:grid-cols-4">
                                <div class="space-y-4 lg:col-span-2">
                                    <div>
                                        <label>Nom del punt</label>
                                        <input
                                            v-model="location.name"
                                            type="text"
                                            class="mt-2 w-full rounded-xl border border-hp-border bg-hp-bg-card p-2 shadow-sm focus:ring-2 focus:ring-hp-primary/50 focus:outline-none"
                                            required
                                        />
                                    </div>
                                    <div>
                                        <label>Tipus de pregunta</label>
                                        <select
                                            v-model="location.question_type"
                                            class="mt-2 w-full rounded-xl border border-hp-border bg-hp-bg-card p-2 shadow-sm focus:ring-2 focus:ring-hp-primary/50 focus:outline-none"
                                        >
                                            <option value="open">Resposta oberta</option>
                                            <option value="multiple_choice">Selecció múltiple</option>
                                            <option value="true_false">Cert/Fals</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label>Pregunta</label>
                                        <input
                                            v-model="location.statement"
                                            type="text"
                                            class="mt-2 w-full rounded-xl border border-hp-border bg-hp-bg-card p-2 shadow-sm focus:ring-2 focus:ring-hp-primary/50 focus:outline-none"
                                            required
                                        />
                                    </div>

                                    <div
                                        v-if="location.question_type === 'multiple_choice'"
                                        class="space-y-3"
                                    >
                                        <div
                                            class="flex items-center justify-between"
                                        >
                                            <p class="text-sm font-medium text-slate-700">Respostes</p>
                                            <button
                                                type="button"
                                                @click="addAnswer(index)"
                                                class="text-sm font-semibold text-hp-primary"
                                            >
                                                Afegir resposta
                                            </button>
                                        </div>
                                        <div class="space-y-2">
                                            <div
                                                v-for="(answer, aIndex) in (location.answers || [])"
                                                :key="`${index}-${aIndex}`"
                                                class="flex items-center gap-2"
                                            >
                                                <input
                                                    :value="location.answers ? location.answers[aIndex] : ''"
                                                    @input="(e) => { if (!location.answers) location.answers = ['']; location.answers[aIndex] = (e.target as HTMLInputElement).value }"
                                                    type="text"
                                                    class="mt-2 w-full rounded-xl border border-hp-border bg-hp-bg-card p-2 shadow-sm focus:ring-2 focus:ring-hp-primary/50 focus:outline-none"
                                                />
                                                <button
                                                    type="button"
                                                    @click="removeAnswer(index, aIndex)"
                                                    class="text-sm font-semibold text-red-500"
                                                >
                                                    Eliminar
                                                </button>
                                            </div>
                                        </div>
                                        <div>
                                            <label>Resposta correcta</label>
                                            <input
                                                v-model="location.correct_answer"
                                                type="text"
                                                class="mt-2 w-full rounded-xl border border-hp-border bg-hp-bg-card p-2 shadow-sm focus:ring-2 focus:ring-hp-primary/50 focus:outline-none"
                                            />
                                        </div>
                                    </div>

                                    <div v-if="location.question_type === 'true_false'">
                                        <label>Resposta correcta</label>
                                        <select
                                            v-model="location.correct_answer"
                                            class="mt-2 w-full rounded-xl border border-hp-border bg-hp-bg-card p-2 shadow-sm focus:ring-2 focus:ring-hp-primary/50 focus:outline-none"
                                        >
                                            <option value="">Selecciona</option>
                                            <option value="true">Cert</option>
                                            <option value="false">Fals</option>
                                        </select>
                                    </div>
                                </div>

                                <div
                                    class="rounded-2xl border border-hp-border bg-hp-bg-card p-3 shadow-sm lg:col-span-2"
                                >
                                    <h3
                                        class="text-sm font-semibold text-slate-700"
                                    >
                                        Ubicació
                                    </h3>
                                    <div
                                        class="mt-3 h-56 overflow-hidden rounded-xl"
                                    >
                                        <Map
                                            @location-selected="(coords) => setLocationCoords(index, coords)"
                                            :initialLatitude="location.latitude"
                                            :initialLongitude="location.longitude"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <button
                    type="submit"
                    class="mb-5 inline-flex items-center justify-center rounded-full bg-hp-primary-dark px-6 py-3 font-semibold text-white shadow-sm shadow-hp-primary-light transition hover:bg-hp-primary"
                >
                    Actualitzar Gimcana
                </button>
            </section>

            <aside class="space-y-5">
                <div
                    class="rounded-3xl border border-hp-border bg-hp-bg-card p-5 shadow-sm lg:sticky lg:top-6"
                >
                    <div class="flex items-center justify-between">
                        <h2 class="text-base font-semibold text-hp-text">
                            Mapa general
                        </h2>
                        <span
                            class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-hp-primary-dark"
                        >
                            {{ overviewMarkers.length }} punts
                        </span>
                    </div>
                    <div
                        class="mt-4 h-72 overflow-hidden rounded-2xl border border-hp-border"
                    >
                        <OverviewMap :markers="overviewMarkers" />
                    </div>
                    <div class="mt-4 space-y-2 text-xs text-slate-600">
                        <div
                            v-for="(marker, index) in overviewMarkers"
                            :key="`${marker.name}-${index}`"
                            class="flex items-center justify-between rounded-xl border border-hp-border bg-hp-bg-card px-3 py-2"
                        >
                            <span class="font-medium text-slate-700">{{
                                marker.name
                            }}</span>
                            <span class="text-slate-500"
                                >{{ marker.latitude }},
                                {{ marker.longitude }}</span
                            >
                        </div>
                    </div>
                </div>
            </aside>
        </form>
    </div>
</template>
