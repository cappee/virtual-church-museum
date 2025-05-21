<template>
  <div ref="panoramaViewer" class="viewer"></div>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import { useRouter } from 'vue-router'
import { Viewer } from '@photo-sphere-viewer/core'
import { MarkersPlugin } from '@photo-sphere-viewer/markers-plugin'
import '@photo-sphere-viewer/core/index.css'
import '@photo-sphere-viewer/markers-plugin/index.css'
import coffee from '@/assets/skybox_cropped.jpg'
import painting from '@/assets/google_maps_pin_PNG76.png'

const router = useRouter()
const panoramaViewer = ref(null)

onMounted(async () => {
  const viewer = new Viewer({
    container: panoramaViewer.value,
    panorama: coffee,
    navbar: false,
    mousewheel: false,
    touchmoveTwoFingers: true,
    plugins: [MarkersPlugin],
  })

  const markersPlugin = viewer.getPlugin(MarkersPlugin)

  fetch('http://localhost:8000/api/works.php')
    .then((res) => res.text())
    .then((xmlText) => {
      const parser = new DOMParser()
      const xmlDoc = parser.parseFromString(xmlText, 'text/xml')

      const works = [...xmlDoc.getElementsByTagName('work')]

      for (const work of works) {
        const title = work.getElementsByTagName('title')[0]?.textContent
        const coord = work.getElementsByTagName('coord')[0]
        const yaw = parseFloat(coord.getElementsByTagName('yaw')[0]?.textContent)
        const pitch = parseFloat(coord.getElementsByTagName('pitch')[0]?.textContent)

        markersPlugin.addMarker({
          id: `${title}`,
          position: { yaw, pitch },
          tooltip: title,
          image: painting,
          size: { width: 32, height: 32 },
          anchor: 'bottom center',
        })
      }
    })

  viewer.addEventListener('click', ({ data }) => {
    const { yaw, pitch } = data
    markersPlugin.addMarker({
      id: `marker-${Date.now()}`,
      position: { yaw, pitch },
      tooltip: `yaw: ${yaw.toFixed(2)}, pitch: ${pitch.toFixed(2)}`,
      image: painting,
      size: { width: 32, height: 32 },
      anchor: 'bottom center',
    })
  })

  markersPlugin.addEventListener('select-marker', ({ marker }) => {
    router.push(`/opera/${encodeURIComponent(marker.id)}`)
  })
})
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
