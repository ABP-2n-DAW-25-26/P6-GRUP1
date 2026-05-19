<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import L from 'leaflet';
import {
    computed,
    nextTick,
    onBeforeUnmount,
    onMounted,
    ref,
    watch,
} from 'vue';
import 'leaflet/dist/leaflet.css';

interface Location {
    id: number;
    name: string;
    description: string | null;
    statement: string | null;
    question_type: 'open' | 'multiple_choice' | 'true_false' | 'photo';
    answer: string | null;
    correct_answer: string | null;
    latitude: string | null;
    longitude: string | null;
    order: number | null;
}

const props = defineProps<{
    locations: Location[];
}>();

const currentIndex = ref(0);
const userAnswer = ref('');
const selectedFile = ref<File | null>(null);
const feedback = ref('');
const mapElement = ref<HTMLElement | null>(null);

let map: L.Map | null = null;
let markerLayer: L.LayerGroup | null = null;

const orderedLocations = computed(() => {
    const locations = props.locations.slice();

    locations.sort((a, b) => {
        const first = a.order || a.id;
        const second = b.order || b.id;

        return first - second;
    });

    return locations;
});

const currentLocation = computed(
    () => orderedLocations.value[currentIndex.value] ?? null,
);
const totalLocations = computed(() => orderedLocations.value.length);
const completed = computed(
    () =>
        totalLocations.value > 0 && currentIndex.value >= totalLocations.value,
);
const upcomingLocations = computed(() =>
    orderedLocations.value.slice(currentIndex.value + 1),
);

const currentOptions = computed(() => {
    try {
        return JSON.parse(currentLocation.value?.answer || '[]');
    } catch {
        return [];
    }
});

const validMarkers = computed(() => {
    return orderedLocations.value.filter(
        (location) => location.latitude && location.longitude,
    );
});

userAnswer.value.trim().toLowerCase();

const translateYFor = (index: number) => index * 3;

const scaleFor = (index: number) => {
    return 1 - index * 0.05;
};

const isAnswerComplete = computed(() => {
    if (!currentLocation.value) {
        return false;
    }

    return userAnswer.value.trim().length > 0;
});

const resetQuestionState = () => {
    userAnswer.value = '';
    selectedFile.value = null;
    feedback.value = '';
};

const completeQuestion = () => {
    if (!currentLocation.value || !isAnswerComplete.value) {
        feedback.value = 'Completa aquesta prova abans de continuar.';

        return;
    }

    const correct =
        userAnswer.value.trim().toLowerCase() ===
        currentLocation.value.correct_answer?.trim().toLowerCase();

    if (
        currentLocation.value.question_type !== 'open' &&
        currentLocation.value.correct_answer &&
        !correct
    ) {
        currentIndex.value += 1;
        resetQuestionState();
    }
};

const createMarkerIcon = (isActive: boolean, isDone: boolean) => {
    const background = isActive ? '#00796b' : isDone ? '#76b7a8' : '#d8efe9';
    const border = isActive ? '#ffffff' : '#00796b';
    const ring = isActive
        ? '<span class="absolute -inset-3 rounded-full bg-hp-primary/20"></span>'
        : '';

    return L.divIcon({
        className: '',
        html: `
      <span class="relative flex h-9 w-9 items-center justify-center rounded-full shadow-lg" style="background:${background};border:3px solid ${border}">
        ${ring}
        <span class="relative h-2.5 w-2.5 rounded-full bg-white"></span>
      </span>
    `,
        iconSize: [36, 36],
        iconAnchor: [18, 18],
    });
};

const renderMarkers = () => {
    if (!map) {
        return;
    }

    if (!markerLayer) {
        markerLayer = L.layerGroup().addTo(map);
    }

    markerLayer.clearLayers();

    const bounds: L.LatLngTuple[] = [];

    validMarkers.value.forEach((location) => {
        const lat = parseFloat(location.latitude ?? '');
        const lng = parseFloat(location.longitude ?? '');

        if (Number.isNaN(lat) || Number.isNaN(lng)) {
            return;
        }

        bounds.push([lat, lng]);

        L.marker([lat, lng], {
            icon: createMarkerIcon(
                location.id === currentLocation.value?.id,
                orderedLocations.value.findIndex(
                    (item) => item.id === location.id,
                ) < currentIndex.value,
            ),
        })
            .addTo(markerLayer as L.LayerGroup)
            .bindPopup(location.name);
    });

    const active = currentLocation.value;

    if (active?.latitude && active.longitude) {
        const activeLat = parseFloat(active.latitude);
        const activeLng = parseFloat(active.longitude);

        if (!Number.isNaN(activeLat) && !Number.isNaN(activeLng)) {
            map.setView([activeLat, activeLng], 15);

            return;
        }
    }

    if (bounds.length > 0) {
        map.fitBounds(bounds, { padding: [36, 36] });
    }
};

onMounted(async () => {
    await nextTick();

    if (!mapElement.value) {
        return;
    }

    const first = validMarkers.value[0];
    const center =
        first?.latitude && first.longitude
            ? ([
                  parseFloat(first.latitude),
                  parseFloat(first.longitude),
              ] as L.LatLngExpression)
            : ([42.2655, 2.9581] as L.LatLngExpression);

    map = L.map(mapElement.value, {
        zoomControl: false,
    }).setView(center, 14);

    L.control.zoom({ position: 'topright' }).addTo(map);

    // L.tileLayer('https://tiles.stadiamaps.com/tiles/stamen_toner_lite/{z}/{x}/{y}{r}.{ext}', {
    //   minZoom: 0,
    //   maxZoom: 20,
    //   attribution: '&copy; <a href="https://www.stadiamaps.com/" target="_blank">Stadia Maps</a> &copy; <a href="https://www.stamen.com/" target="_blank">Stamen Design</a> &copy; <a href="https://openmaptiles.org/" target="_blank">OpenMapTiles</a> &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
    //   ext: 'png',
    // }).addTo(map)

    renderMarkers();
});

watch([orderedLocations, currentIndex], () => {
    renderMarkers();
});

onBeforeUnmount(() => {
    if (map) {
        map.remove();
        map = null;
    }
});
</script>

<template>
    <Head title="Gimcana" />

    <div class="relative min-h-full min-w-full overflow-hidden">
        <div ref="mapElement" class="absolute inset-0 z-0 rounded-xl"></div>
        <div
            class="pointer-events-none absolute inset-0 z-10 rounded-xl bg-hp-primary/10"
        ></div>

        <div
            class="pointer-events-none relative z-20 flex min-h-[calc(100vh-6rem)] flex-col justify-start gap-3 px-3 py-3 md:items-start md:gap-6 md:px-4 md:py-4 lg:min-h-[calc(100vh-10rem)]"
        >
            <div class="flex w-full flex-col items-start gap-2 md:max-w-sm">
                <section
                    v-if="currentLocation && !completed"
                    class="pointer-events-auto z-40 w-full rounded-2xl border-b-4 border-hp-primary bg-white px-4 py-3 shadow-xl md:px-5 md:py-4"
                >
                    <p class="font-bold tracking-widest text-hp-text-dim">
                        SEGUENT PARADA:
                    </p>
                    <h1 class="mt-1 text-lg font-bold text-hp-text md:text-2xl">
                        {{ currentLocation.name }}
                    </h1>
                    <p
                        v-if="currentLocation.description"
                        class="mt-2 text-xs text-hp-text-dim md:mt-3 md:text-sm"
                    >
                        {{ currentLocation.description }}
                    </p>
                </section>
                <section
                    v-if="upcomingLocations.length > 0 && !completed"
                    class="pointer-events-none -mt-2 hidden w-full max-w-sm md:block"
                >
                    <div class="ml-0 flex w-full max-w-sm flex-col items-start">
                        <div
                            v-for="(location, index) in upcomingLocations"
                            :key="location.id"
                            class="w-full"
                            :style="{
                                marginTop: index === 0 ? '-0.35rem' : '-1rem',
                                zIndex: String(
                                    upcomingLocations.length - index,
                                ),
                            }"
                        >
                            <div
                                class="pointer-events-auto w-full rounded-b-2xl border-b-4 border-hp-primary bg-white/80 px-4 py-3 shadow-lg transition-transform duration-300"
                                :style="{
                                    transform: `translateY(${translateYFor(index)}px) scale(${scaleFor(index)})`,
                                }"
                            >
                                <p
                                    class="text-xs font-bold tracking-widest text-hp-text-dim"
                                >
                                    Prova {{ currentIndex + index + 2 }}
                                </p>
                                <h1
                                    class="mt-1 text-base font-bold text-hp-text"
                                >
                                    {{ location.name }}
                                </h1>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <section
                v-if="currentLocation && !completed"
                class="pointer-events-auto mt-auto mb-4 w-full rounded-4xl bg-linear-to-br from-hp-primary to-hp-primary-dark p-4 text-white shadow-2xl sm:max-w-md md:w-80 md:max-w-sm md:self-start md:p-6"
            >
                <div
                    class="inline-flex rounded-full bg-white/20 px-2.5 py-1 text-xs font-bold tracking-wide md:px-3 md:text-xs"
                >
                    ACTIVITAT {{ currentIndex + 1 }} DE {{ totalLocations }}
                </div>

                <h2 class="mt-4 text-xl font-bold md:mt-5 md:text-2xl">
                    {{ currentLocation.statement }}
                </h2>

                <div class="mt-4 md:mt-6">
                    <div
                        v-if="
                            currentLocation.question_type === 'multiple_choice'
                        "
                        class="grid gap-3"
                    >
                        <button
                            v-for="option in currentOptions"
                            :key="option"
                            type="button"
                            class="rounded-2xl px-3 py-2 text-left text-sm font-semibold transition hover:bg-hp-secondary/15 md:px-4 md:py-3"
                            :class="
                                userAnswer === option
                                    ? 'bg-white text-hp-primary-dark'
                                    : 'bg-hp-secondary/10 text-white'
                            "
                            @click="userAnswer = option"
                        >
                            {{ option }}
                        </button>
                    </div>

                    <div
                        v-else-if="
                            currentLocation.question_type === 'true_false'
                        "
                        class="grid grid-cols-2 gap-3"
                    >
                        <button
                            type="button"
                            class="borde-white rounded-2xl border px-3 py-2 text-sm font-semibold transition hover:bg-hp-secondary/15 md:px-4 md:py-3"
                            :class="
                                userAnswer === 'true'
                                    ? 'bg-white text-hp-primary-dark'
                                    : 'bg-hp-secondary/10 text-white'
                            "
                            @click="userAnswer = 'true'"
                        >
                            Cert
                        </button>
                        <button
                            type="button"
                            class="rounded-2xl border border-white px-3 py-2 text-sm font-semibold transition hover:bg-hp-secondary/15 md:px-4 md:py-3"
                            :class="
                                userAnswer === 'false'
                                    ? 'bg-white text-hp-primary-dark'
                                    : 'bg-hp-secondary/10 text-white'
                            "
                            @click="userAnswer = 'false'"
                        >
                            Fals
                        </button>
                    </div>

                    <textarea
                        v-else
                        v-model="userAnswer"
                        rows="4"
                        placeholder="Escriu la resposta"
                        class="w-full rounded-2xl border border-white bg-white p-3 text-sm text-black outline-none focus:ring-2 focus:ring-hp-primary md:p-4"
                    >
                    </textarea>
                </div>

                <p
                    v-if="feedback"
                    class="mt-3 rounded-2xl bg-white/15 px-3 py-2 text-xs font-semibold md:mt-4 md:px-4 md:py-3 md:text-sm"
                >
                    {{ feedback }}
                </p>

                <button
                    type="button"
                    :disabled="!isAnswerComplete"
                    @click="completeQuestion"
                    class="mt-4 w-full rounded-2xl bg-white px-4 py-2.5 text-sm font-bold text-hp-primary-dark shadow-lg transition hover:bg-hp-secondary/15 disabled:cursor-not-allowed disabled:opacity-60 md:mt-5 md:px-5 md:py-3"
                >
                    Completar prova
                </button>
            </section>

            <section
                v-else-if="completed"
                class="pointer-events-auto mt-auto mb-4 w-full rounded-4xl bg-white p-6 text-center shadow-2xl sm:max-w-md md:w-80 md:max-w-sm md:self-start"
            >
                <p
                    class="text-xs font-bold tracking-widest text-hp-primary uppercase"
                >
                    Gimcana completada
                </p>
                <h1 class="mt-2 text-2xl font-bold text-slate-800">
                    Has completat totes les proves
                </h1>
            </section>
        </div>
    </div>
</template>
