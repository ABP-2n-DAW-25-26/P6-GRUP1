<script setup lang="ts">
import { Head, usePage, router } from '@inertiajs/vue3';
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

interface Theme {
    id: number;
    name: string;
    primary: string;
    primary_dark: string;
    secondary: string;
    text: string;
    text_secondary: string;
    background: string;
    background_card: string;
}

const props = defineProps<{
    locations: Location[];
    gimcana: { id: number; exchange_id: number; theme_id: number | null };
    theme: Omit<Theme, 'id'> & { id: number | null };
    themes: Theme[];
}>();

const page = usePage<{ auth: { user: { role: string } | null } }>();
const canChangeTheme = computed(() => {
    const role = page.props.auth.user?.role;
    return role === 'admin' || role === 'teacher';
});

const themeStyle = computed(() => ({
    '--hp-primary': props.theme.primary,
    '--hp-primary-dark': props.theme.primary_dark,
    '--hp-primary-darker': props.theme.primary_dark,
    '--hp-primary-light': props.theme.secondary,
}));

const themeModalOpen = ref(false);
const selectedThemeId = ref<number | null>(props.theme.id);
const applyingTheme = ref(false);

const openThemeModal = () => {
    selectedThemeId.value = props.theme.id;
    themeModalOpen.value = true;
};

const closeThemeModal = () => {
    if (applyingTheme.value) return;
    themeModalOpen.value = false;
};

const applyTheme = () => {
    applyingTheme.value = true;
    router.patch(
        `/exchange/${props.gimcana.exchange_id}/gimcana/${props.gimcana.id}/theme`,
        { theme_id: selectedThemeId.value },
        {
            preserveScroll: true,
            onFinish: () => {
                applyingTheme.value = false;
                themeModalOpen.value = false;
            },
        },
    );
};

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

    const correctAnswer = currentLocation.value.correct_answer
        ?.trim()
        .toLowerCase();
    const userValue = userAnswer.value.trim().toLowerCase();
    const correct = !correctAnswer || userValue === correctAnswer;

    if (!correct) {
        feedback.value = 'Resposta incorrecta. Torna-ho a intentar.';

        return;
    }

    currentIndex.value += 1;
    resetQuestionState();
};

const createMarkerIcon = (isActive: boolean, isDone: boolean) => {
    const background = isActive
        ? props.theme.primary
        : isDone
          ? props.theme.secondary
          : props.theme.background_card;
    const border = isActive ? '#ffffff' : props.theme.primary;
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

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        minZoom: 0,
        maxZoom: 20,
    }).addTo(map);

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

    <div :style="themeStyle" class="relative min-h-full min-w-full overflow-hidden">
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

        <button
            v-if="canChangeTheme"
            type="button"
            class="pointer-events-auto absolute top-3 right-3 z-30 rounded-full bg-white px-4 py-2 text-sm font-semibold text-hp-primary shadow-lg transition hover:bg-gray-50"
            @click="openThemeModal"
        >
            Canviar tema
        </button>

        <div
            v-if="themeModalOpen"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 px-4"
            @click.self="closeThemeModal"
        >
            <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-xl">
                <div class="space-y-6">
                    <div class="space-y-3">
                        <h2 class="text-lg font-semibold text-gray-900">Canviar tema de la gimcana</h2>
                        <p class="text-sm text-gray-600">
                            Tria un tema per aplicar a aquesta gimcana.
                        </p>
                    </div>
                    <div class="grid max-h-72 grid-cols-1 gap-2 overflow-y-auto">
                        <label
                            class="flex cursor-pointer items-center gap-3 rounded-xl border border-gray-200 p-3 transition hover:bg-gray-50"
                            :class="selectedThemeId === null ? 'border-hp-primary bg-hp-primary/5' : ''"
                        >
                            <input
                                type="radio"
                                name="theme"
                                :value="null"
                                v-model="selectedThemeId"
                                class="h-4 w-4"
                            />
                            <span class="text-sm font-medium text-gray-700">Sense tema (per defecte)</span>
                        </label>
                        <label
                            v-for="t in themes"
                            :key="t.id"
                            class="flex cursor-pointer items-center gap-3 rounded-xl border border-gray-200 p-3 transition hover:bg-gray-50"
                            :class="selectedThemeId === t.id ? 'border-hp-primary bg-hp-primary/5' : ''"
                        >
                            <input
                                type="radio"
                                name="theme"
                                :value="t.id"
                                v-model="selectedThemeId"
                                class="h-4 w-4"
                            />
                            <span class="flex-1 text-sm font-medium text-gray-700">{{ t.name }}</span>
                            <span class="flex gap-1">
                                <span class="h-5 w-5 rounded-full border border-gray-200" :style="{ background: t.primary }"></span>
                                <span class="h-5 w-5 rounded-full border border-gray-200" :style="{ background: t.primary_dark }"></span>
                                <span class="h-5 w-5 rounded-full border border-gray-200" :style="{ background: t.secondary }"></span>
                            </span>
                        </label>
                    </div>
                    <div class="flex gap-3 pt-2">
                        <button
                            type="button"
                            class="flex-1 rounded-md border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50 disabled:opacity-50"
                            :disabled="applyingTheme"
                            @click="closeThemeModal"
                        >
                            Cancel·lar
                        </button>
                        <button
                            type="button"
                            class="flex-1 rounded-md bg-hp-primary px-4 py-2 text-sm font-semibold text-white transition hover:opacity-90 disabled:opacity-50"
                            :disabled="applyingTheme"
                            @click="applyTheme"
                        >
                            {{ applyingTheme ? 'Aplicant...' : 'Aplicar' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
