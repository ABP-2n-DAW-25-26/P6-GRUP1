<template>
    <div id="map" class="w-full h-full rounded-xl shadow"></div>

    <div class="mt-4 text-sm text-gray-700">
      <p><strong>Lat:</strong> {{ lat }}</p>
      <p><strong>Lng:</strong> {{ lng }}</p>
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import L from 'leaflet'
import 'leaflet/dist/leaflet.css'

const lat = ref(null)
const lng = ref(null)

let map
let marker

onMounted(() => {
  map = L.map('map').setView([42.2655, 2.9581], 13)

  L.tileLayer('https://tiles.stadiamaps.com/tiles/alidade_smooth/{z}/{x}/{y}{r}.{ext}', {
	minZoom: 0,
	maxZoom: 20,
	attribution: '&copy; <a href="https://www.stadiamaps.com/" target="_blank">Stadia Maps</a> &copy; <a href="https://openmaptiles.org/" target="_blank">OpenMapTiles</a> &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
	ext: 'png'
}).addTo(map)

  // Click al mapa
  map.on('click', (e) => {
    lat.value = e.latlng.lat
    lng.value = e.latlng.lng

    // marker
    if (marker) {
      marker.setLatLng(e.latlng)
    } else {
      marker = L.marker(e.latlng).addTo(map)
    }
  })
})
</script>