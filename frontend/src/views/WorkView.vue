<template>
  <main class="container" style="margin-top: 2rem">
    <article v-if="opera">
      <header>
        <h1>{{ opera.title }}</h1>
      </header>
      <p><strong>Yaw:</strong> {{ opera.yaw }}</p>
      <p><strong>Pitch:</strong> {{ opera.pitch }}</p>
      <p><strong>Descrizione:</strong> {{ opera.description }}</p>
      <p><strong>Location:</strong> {{ opera.location }}</p>
      <p><strong>Anno:</strong> {{ opera.year }}</p>
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
    const id = node.getElementsByTagName('id')[0]?.textContent || ''
    if (id === route.params.id) {
      const title = node.getElementsByTagName('title')[0]?.textContent || ''
      const description = node.getElementsByTagName('description')[0]?.textContent || ''
      const location = node.getElementsByTagName('location')[0]?.textContent || ''
      const year = parseInt(node.getElementsByTagName('year')[0]?.textContent || '0')
      const coord = node.getElementsByTagName('coord')[0]
      const yaw = parseFloat(coord?.getElementsByTagName('yaw')[0]?.textContent || 0)
      const pitch = parseFloat(coord?.getElementsByTagName('pitch')[0]?.textContent || 0)
      opera.value = { title: title, yaw, pitch, description, location, year }
      break
    }
  }
})
</script>
