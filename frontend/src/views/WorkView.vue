<template>
  <main class="container" style="margin-top: 2rem; max-width: 900px; margin-inline: auto">
    <div v-if="work" style="display: flex; flex-direction: column; gap: 2rem">
      <div style="display: flex; gap: 2rem; flex-wrap: wrap; align-items: flex-start">
        <div style="flex: 1 1 300px">
          <h1 style="font-size: 2rem; margin: 0">{{ work.title }}</h1>
          <p style="margin: 0 0 0.5rem 0"><strong>Anno:</strong> {{ work.year }}</p>
        </div>

        <!-- Immagine -->
        <div style="flex: 0 0 300px; display: flex; justify-content: center">
          <ImageCarousel :images="work.images" />
        </div>

        <!-- Anno + Titolo -->
      </div>

      <div>
        <p style="margin-top: 0">{{ work.description }}</p>
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
          :disabled="isLoading"
          style="
            margin-top: 1rem;
            background-color: #28a745;
            color: white;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 5px;
          "
        >
          {{ isLoading ? 'Attendere...' : "Chiedi all'intelligenza artificiale" }}
        </button>
      </form>
      <div
        style="
          margin-top: 1.5rem;
          background-color: #f8f9fa;
          padding: 1rem;
          border-radius: 6px;
          border: 1px solid #ddd;
          min-height: 120px;
          white-space: pre-wrap;
        "
      >
        <p><strong>Risposta:</strong></p>
        <p v-if="aiResponse">{{ aiResponse }}</p>
        <p v-else style="opacity: 0">Spazio riservato alla risposta</p>
      </div>
    </section>
  </main>
</template>
<script setup>
import { onMounted, ref } from 'vue'
import { useRoute } from 'vue-router'
import ImageCarousel from '@/components/ImageCarousel.vue'

const route = useRoute()
const work = ref(null)

onMounted(() => {
  fetch('http://localhost:8000/api/works.php?action=list')
    .then((res) => res.json())
    .then((allWorks) => {
      const found = allWorks.find((work) => work.id === route.params.id)
      if (found) {
        console.log('Opera trovata:', found)
        work.value = found
      }
    })
})

const question = ref('')
const aiResponse = ref('')
const isLoading = ref(false)

function askAI() {
  aiResponse.value = ''
  isLoading.value = true

  fetch('http://localhost:8000/api/question.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({
      question: question.value,
      id: route.params.id,
    }),
  })
    .then((res) => res.json())
    .then((data) => {
      const fullPrompt = data.prompt
      return fetch('http://localhost:11434/api/generate', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          model: 'gemma3:1b-it-q4_K_M',
          prompt: fullPrompt,
          stream: true,
        }),
      })
    })
    .then((response) => {
      const reader = response.body.getReader()
      const decoder = new TextDecoder()

      function readChunk() {
        return reader.read().then(({ done, value }) => {
          if (done) {
            isLoading.value = false
            return
          }

          const chunk = decoder.decode(value, { stream: true })
          const lines = chunk.split('\n').filter((line) => line.trim() !== '')

          lines.forEach((line) => {
            try {
              const data = JSON.parse(line)
              if (data.response) {
                const cleaned = data.response.replace(/\*/g, '')
                aiResponse.value += cleaned
              }
            } catch (e) {
              console.warn('Errore parsing JSON:', line)
            }
          })

          return readChunk()
        })
      }

      return readChunk()
    })
    .catch((error) => {
      isLoading.value = false
      aiResponse.value = 'Errore: ' + error.message
      console.error('Errore durante la richiesta:', error)
    })
}
</script>
