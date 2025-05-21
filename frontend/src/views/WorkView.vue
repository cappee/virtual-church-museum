<template>
  <main class="container">
    <article v-if="opera">
      <header>
        <h1>{{ opera.title }}</h1>
      </header>
      <p><strong>Yaw:</strong> {{ opera.yaw }}</p>
      <p><strong>Pitch:</strong> {{ opera.pitch }}</p>
      <footer>
        <a href="/" role="button">Torna alla mappa</a>
      </footer>
    </article>
    <article v-else>
      <p>Caricamento...</p>
    </article>
  </main>
</template>
<script setup>
import { onMounted, ref } from 'vue'
import { useRoute } from 'vue-router'

const route = useRoute()
const opera = ref(null)

onMounted(async () => {
  const res = await fetch('http://localhost:8000/api/works.php')
  const xmlText = await res.text()
  const parser = new DOMParser()
  const xmlDoc = parser.parseFromString(xmlText, 'application/xml')

  const worksNodes = [...xmlDoc.getElementsByTagName('work')]
  for (const node of worksNodes) {
    const title = node.getElementsByTagName('title')[0]?.textContent || ''
    if (title === route.params.id) {
      const coord = node.getElementsByTagName('coord')[0]
      const yaw = parseFloat(coord?.getElementsByTagName('yaw')[0]?.textContent || 0)
      const pitch = parseFloat(coord?.getElementsByTagName('pitch')[0]?.textContent || 0)
      opera.value = { title, yaw, pitch }
      break
    }
  }
})
</script>
