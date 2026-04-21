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
  L.tileLayer('https://tiles.stadiamaps.com/tiles/alidade_smooth/{z}/{x}/{y}{r}.{ext}', {
	minZoom: 0,
	maxZoom: 20,
	attribution: '&copy; <a href="https://www.stadiamaps.com/" target="_blank">Stadia Maps</a> &copy; <a href="https://openmaptiles.org/" target="_blank">OpenMapTiles</a> &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
	ext: 'png'
}).addTo(map)

  // marker custom
  const customIcon = L.divIcon({
    className: '', // evitar estils de leaflet
    html: `
      <div class="relative">
        <div class="w-3 h-3 bg-teal-400 rounded-full border-2 border-white shadow-md"></div>
      </div>
    `,
    iconSize: [12, 12],
    iconAnchor: [6, 6],
  })
  
  //Afegir marcadors 
  props.markers.forEach((m) => {
    if (m.latitude && m.longitude) {
      L.marker([parseFloat(m.latitude), parseFloat(m.longitude)], {
        icon: customIcon,
      })
        .addTo(map)
        .bindPopup(m.name)
    }
  })
})
</script>