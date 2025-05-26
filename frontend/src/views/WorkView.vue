<template>
  <main class="container" style="margin-top: 2rem; max-width: 900px; margin-inline: auto">
    <div v-if="work" style="display: flex; gap: 2rem; flex-wrap: wrap">
      <div style="flex: 1 1 300px">
        <h1 style="font-size: 2rem; margin-bottom: 1rem">{{ work.title }}</h1>
        <p>{{ work.description }}</p>
        <p><strong>Anno:</strong> {{ work.year }}</p>
      </div>

      <div style="flex: 1 1 300px; display: flex; justify-content: center">
        <img
          :src="work.image"
          alt="Immagine dell'opera"
          style="max-width: 100%; max-height: 300px; border-radius: 8px; object-fit: cover"
        />
      </div>
    </div>

    <div v-else style="text-align: center">
      <p>Caricamento...</p>
    </div>

    <section style="margin-top: 3rem; padding-top: 2rem; border-top: 1px solid #ccc">
      <h2 style="margin-bottom: 1rem">Hai una domanda sull'opera?</h2>
      <form @submit.prevent="askAI">
        <textarea
          v-model="question"
          placeholder="Scrivi la tua domanda..."
          rows="4"
          style="width: 100%; padding: 0.75rem; border-radius: 6px; border: 1px solid #ccc"
        ></textarea>
        <button
          type="submit"
          style="
            margin-top: 1rem;
            background-color: #28a745;
            color: white;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 5px;
          "
        >
          Chiedi all'intelligenza artificiale
        </button>
      </form>
      <div
        v-if="aiResponse"
        style="
          margin-top: 1.5rem;
          background-color: #f8f9fa;
          padding: 1rem;
          border-radius: 6px;
          border: 1px solid #ddd;
        "
      >
        <p><strong>Risposta:</strong> {{ aiResponse }}</p>
      </div>
    </section>
  </main>
</template>
<script setup>
import { onMounted, ref } from 'vue'
import { useRoute } from 'vue-router'

const route = useRoute()
const work = ref(null)

onMounted(() => {
  fetch('http://localhost:8000/api/works.php?action=list')
    .then((res) => res.json())
    .then((allWorks) => {
      const found = allWorks.find((work) => work.id === route.params.id)
      if (found) {
        work.value = {
          title: found.title || '',
          description: found.description || '',
          year: parseInt(found.year || '0'),
          image: found.image || '',
          yaw: parseFloat(found.yaw || '0'),
          pitch: parseFloat(found.pitch || '0'),
          location: found.location || '',
        }
      }
    })
})
</script>
