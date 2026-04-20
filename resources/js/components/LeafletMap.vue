<template>
  <div id="map" class="w-full h-full rounded-xl"></div>
</template>

<script setup>
import { onMounted } from 'vue'
import L from 'leaflet'
import 'leaflet/dist/leaflet.css'

onMounted(() => {
  //inicialitzar mapa a figueres
  const map = L.map('map').setView([42.2655, 2.9581], 13)
  //afegir la capa de tiles "mapa base" amb 'OpenStreetMap
  L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',//copyright
  }).addTo(map)
  //Afegir marcador 
  L.marker([42.2741, 2.9643]).addTo(map).bindPopup('Cendrassos')
})
</script>