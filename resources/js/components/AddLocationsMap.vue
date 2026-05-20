<template>
    <div ref="mapEl" class="h-full w-full rounded-xl shadow"></div>

    <div class="mt-4 text-sm text-gray-700">
        <p><strong>Lat:</strong> {{ lat }}</p>
        <p><strong>Lng:</strong> {{ lng }}</p>
    </div>
</template>

<script setup>
import L from 'leaflet';
import { onBeforeUnmount, onMounted, ref } from 'vue';
import 'leaflet/dist/leaflet.css';

const props = defineProps({
    initialLatitude: {
        type: String,
        default: null,
    },
    initialLongitude: {
        type: String,
        default: null,
    },
});

const emit = defineEmits(['location-selected']);
const lat = ref(props.initialLatitude ?? null);
const lng = ref(props.initialLongitude ?? null);
const mapEl = ref(null);

let map;
let marker;

onMounted(() => {
    if (!mapEl.value) {
        return;
    }

    const initialLat = props.initialLatitude ? parseFloat(props.initialLatitude) : 42.2655;
    const initialLng = props.initialLongitude ? parseFloat(props.initialLongitude) : 2.9581;
    const initialZoom = props.initialLatitude && props.initialLongitude ? 13 : 13;

    map = L.map(mapEl.value).setView([initialLat, initialLng], initialZoom);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        minZoom: 0,
        maxZoom: 20,
        ext: 'png',
    }).addTo(map);

    if (props.initialLatitude && props.initialLongitude) {
        const latlng = L.latLng(initialLat, initialLng);
        marker = L.marker(latlng).addTo(map);
    }

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        minZoom: 0,
        maxZoom: 20,
        ext: 'png',
    }).addTo(map);

    // Click al mapa
    map.on('click', (e) => {
        lat.value = e.latlng.lat;
        lng.value = e.latlng.lng;

        emit('location-selected', {
            latitude: lat.value,
            longitude: lng.value,
        });

        if (marker) {
            marker.setLatLng(e.latlng);
        } else {
            marker = L.marker(e.latlng).addTo(map);
        }
    });
});

onBeforeUnmount(() => {
    if (map) {
        map.remove();
        map = null;
    }
});
</script>
