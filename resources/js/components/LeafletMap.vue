<template>
  <div id="map" class="w-full h-full rounded-xl"></div>
</template>

<script setup>
import { onMounted } from 'vue'
import L from 'leaflet'
import 'leaflet/dist/leaflet.css'

const props = defineProps({
  markers: {
    type: Array,
    default: () => [],
  },
})

onMounted(() => {
  //inicialitzar mapa segons el primer marcador, sinó a figueres
  const first = props.markers[0]
  const center = first ? [parseFloat(first.latitude), parseFloat(first.longitude)] : [42.2655, 2.9581]

  const map = L.map('map').setView(center, 13)

  //afegir la capa de tiles "mapa base" amb 'OpenStreetMap
  L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',//copyright
  }).addTo(map)

  //Afegir marcadors 
    props.markers.forEach((m) => {
    if (m.latitude && m.longitude) {
      L.marker([parseFloat(m.latitude), parseFloat(m.longitude)])
        .addTo(map)
        .bindPopup(m.name)
    }
  })
})
</script>