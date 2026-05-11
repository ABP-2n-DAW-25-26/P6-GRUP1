<template>
  <div ref="mapElement" class="w-full h-full rounded-xl"></div>
</template>

<script setup>
import { onBeforeUnmount, onMounted, ref, watch } from 'vue'
import L from 'leaflet'
import 'leaflet/dist/leaflet.css'

const props = defineProps({
  markers: {
    type: Array,
    default: () => [],
  },
})

const mapElement = ref(null)
let map
let markerLayer

const createMarkerLayer = () => {
  if (!map) return

  if (markerLayer) {
    markerLayer.clearLayers()
  } else {
    markerLayer = L.layerGroup().addTo(map)
  }

  const customIcon = L.divIcon({
    className: '',
    html: `
      <div class="relative">
        <div class="w-3 h-3 bg-teal-400 rounded-full border-2 border-white shadow-md"></div>
      </div>
    `,
    iconSize: [12, 12],
    iconAnchor: [6, 6],
  })

  const bounds = []

  props.markers.forEach((m) => {
    if (m.latitude && m.longitude) {
      const lat = parseFloat(m.latitude)
      const lng = parseFloat(m.longitude)
      bounds.push([lat, lng])
      L.marker([lat, lng], { icon: customIcon })
        .addTo(markerLayer)
        .bindPopup(m.name || '')
    }
  })

  if (bounds.length > 0) {
    map.fitBounds(bounds, { padding: [24, 24] })
  }
}

onMounted(() => {
  if (!mapElement.value) return

  const first = props.markers[0]
  const center = first ? [parseFloat(first.latitude), parseFloat(first.longitude)] : [42.2655, 2.9581]

  map = L.map(mapElement.value).setView(center, 13)

  L.tileLayer('https://tiles.stadiamaps.com/tiles/alidade_smooth/{z}/{x}/{y}{r}.{ext}', {
	minZoom: 0,
	maxZoom: 20,
	attribution: '&copy; <a href="https://www.stadiamaps.com/" target="_blank">Stadia Maps</a> &copy; <a href="https://openmaptiles.org/" target="_blank">OpenMapTiles</a> &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
	ext: 'png'
}).addTo(map)

  createMarkerLayer()
})

watch(
  () => props.markers,
  () => {
    createMarkerLayer()
  },
  { deep: true }
)

onBeforeUnmount(() => {
  if (map) {
    map.remove()
    map = null
  }
})
</script>