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

const emit = defineEmits(['location-selected']);
const lat = ref(null);
const lng = ref(null);
const mapEl = ref(null);

let map;
let marker;

onMounted(() => {
    if (!mapEl.value) {
        return;
    }

    map = L.map(mapEl.value).setView([42.2655, 2.9581], 13);

    L.tileLayer(
        'https://tile.openstreetmap.org/{z}/{x}/{y}.png',
        {
            minZoom: 0,
            maxZoom: 20,
            ext: 'png',
        },
    ).addTo(map);

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
