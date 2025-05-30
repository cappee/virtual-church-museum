<template>
  <div ref="panoramaViewer" class="viewer"></div>
</template>

<script setup lang="ts">
import { onMounted, ref, watch } from 'vue'
import { useRouter } from 'vue-router'
import { Viewer } from '@photo-sphere-viewer/core'
import { MarkersPlugin } from '@photo-sphere-viewer/markers-plugin'
import '@photo-sphere-viewer/core/index.css'
import '@photo-sphere-viewer/markers-plugin/index.css'
import interior from '@/assets/skybox_interior.jpg'
import exterior from '@/assets/skybox_exterior.jpg'
import pin from '@/assets/google_maps_pin_PNG76.png'

const router = useRouter()
const panoramaViewer = ref(null)

const props = defineProps<{
  photo: 'interior' | 'exterior'
}>()

let viewer: Viewer | null = null
let markersPlugin: MarkersPlugin | null = null
let allWorks: any[] = []

const photoMap = {
  interior,
  exterior,
}

function updateMarkers(photo: 'interior' | 'exterior') {
  if (!markersPlugin) return
  markersPlugin.clearMarkers()

  const filtered = allWorks.filter((work) => work.location === photo)

  for (const work of filtered) {
    markersPlugin.addMarker({
      id: work.id,
      position: { yaw: work.yaw, pitch: work.pitch },
      tooltip: work.title,
      image: pin,
      size: { width: 32, height: 32 },
      anchor: 'bottom center',
    })
  }
}

onMounted(() => {
  viewer = new Viewer({
    container: panoramaViewer.value!,
    panorama: photoMap[props.photo],
    navbar: false,
    mousewheel: false,
    touchmoveTwoFingers: false,
    plugins: [MarkersPlugin],
  })

  markersPlugin = viewer.getPlugin(MarkersPlugin) as MarkersPlugin

  fetch('http://localhost:8000/api/works.php')
    .then((res) => res.text())
    .then((xmlText) => {
      const parser = new DOMParser()
      const xmlDoc = parser.parseFromString(xmlText, 'text/xml')

      allWorks = [...xmlDoc.getElementsByTagName('work')].map((work) => {
        const id = work.getElementsByTagName('id')[0]?.textContent || ''
        const title = work.getElementsByTagName('title')[0]?.textContent || ''
        const location = work.getElementsByTagName('location')[0]?.textContent || 'interior'
        const yaw = parseFloat(
          work.getElementsByTagName('coord')[0].getElementsByTagName('yaw')[0]?.textContent || '0',
        )
        const pitch = parseFloat(
          work.getElementsByTagName('coord')[0].getElementsByTagName('pitch')[0]?.textContent ||
            '0',
        )

        return { id, title, location, yaw, pitch }
      })

      updateMarkers(props.photo)
    })

  // Serviva per sapere le coordinate dove aggiungere un marker
  /*viewer.addEventListener('click', ({ data }) => {
    const { yaw, pitch } = data
    markersPlugin?.addMarker({
      id: `marker-${Date.now()}`,
      position: { yaw, pitch },
      tooltip: `yaw: ${yaw.toFixed(2)}, pitch: ${pitch.toFixed(2)}`,
      image: pin,
      size: { width: 32, height: 32 },
      anchor: 'bottom center',
    })
  })*/

  markersPlugin.addEventListener('select-marker', ({ marker }) => {
    router.push(`/opera/${encodeURIComponent(marker.id)}`)
  })
})

watch(
  () => props.photo,
  (newPhoto) => {
    if (viewer) {
      viewer.setPanorama(photoMap[newPhoto])
      updateMarkers(newPhoto)
    }
  },
)
</script>

<style scoped>
.viewer {
  position: fixed;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  z-index: 0;
}
</style>
