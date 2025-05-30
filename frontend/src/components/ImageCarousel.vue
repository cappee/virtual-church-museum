<template>
  <div class="carousel-container">
    <div class="carousel-slide">
      <img :src="currentImage" alt="Immagine dell'opera" />
    </div>
    <div class="carousel-controls" v-if="images.length > 1">
      <button @click="prevImage" :disabled="currentIndex === 0">←</button>
      <button @click="nextImage" :disabled="currentIndex === images.length - 1">→</button>
    </div>
  </div>
</template>
<script setup>
import { ref, computed } from 'vue'

const props = defineProps({
  images: {
    type: Array,
    required: true,
  },
})

const currentIndex = ref(0)

const currentImage = computed(() => props.images[currentIndex.value])

function nextImage() {
  if (currentIndex.value < props.images.length - 1) {
    currentIndex.value++
  }
}

function prevImage() {
  if (currentIndex.value > 0) {
    currentIndex.value--
  }
}
</script>
<style scoped>
.carousel-container {
  position: relative;
  max-width: 600px;
  margin: auto;
  text-align: center;
}

.carousel-slide img {
  width: 100%;
  height: auto;
  max-height: 300px;
  border-radius: 8px;
  object-fit: contain;
}

.carousel-controls {
  margin-top: 1rem;
}

.carousel-controls button {
  background-color: #28a745;
  color: white;
  padding: 0.5rem 1rem;
  margin: 0 0.5rem;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.carousel-controls button:disabled {
  background-color: #ccc;
  cursor: not-allowed;
}
</style>
