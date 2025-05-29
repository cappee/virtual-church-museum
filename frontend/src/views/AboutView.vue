<template>
  <main class="container">
    <section style="margin-top: 1rem">
      <h1>La basilica</h1>
    </section>

    <section>
      <div class="carousel-container">
        <div class="carousel" :style="{ transform: `translateX(-${currentIndex * 100}%)` }">
          <div class="carousel-slide" v-for="(src, index) in images" :key="index">
            <img :src="src" alt="Immagine" />
          </div>
        </div>
      </div>
    </section>

    <section>
      <p>
        Fondata secoli fa, questa chiesa è un simbolo di devozione e arte. Attraverso guerre,
        rinascimenti e restauri, ha mantenuto la sua funzione spirituale e il suo splendore
        architettonico.
      </p>
      <p>
        Le opere custodite al suo interno raccontano la storia di una comunità, di artisti e di
        fedeli. Ancora oggi, questo luogo rappresenta un punto di riferimento per la cultura e la
        fede.
      </p>
    </section>
  </main>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue'

const images = ref([])

const currentIndex = ref(0)

onMounted(() => {
  fetch('http://localhost:8000/api/about_images.php')
    .then((res) => res.json())
    .then((data) => {
      images.value = data
    })

  setInterval(() => {
    currentIndex.value = (currentIndex.value + 1) % images.value.length
  }, 3000)
})
</script>

<style scoped>
.carousel-container {
  width: 100%;
  margin: auto;
  overflow: hidden;
  padding: 10px; /* spazio intorno al carosello */
  box-sizing: border-box;
}

.carousel {
  display: flex;
  transition: transform 0.5s ease;
}

.carousel-slide {
  flex: 0 0 100%;
  display: flex;
  justify-content: center; /* centra orizzontalmente */
  align-items: center; /* centra verticalmente */
  padding: 10px; /* spazio interno, crea i bordi visivi */
  box-sizing: border-box;
}

.carousel-slide img {
  max-width: 90%; /* lascia margine a sinistra e destra */
  max-height: 300px; /* o altra altezza massima */
  object-fit: contain; /* mantiene le proporzioni e non taglia l'immagine */
  border-radius: 8px;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
  background: #fff; /* sfondo bianco per foto verticali con spazio laterale */
}

.text-section h2 {
  font-size: 1.8rem;
  margin-bottom: 1rem;
}

.text-section p {
  font-size: 1rem;
  line-height: 1.6;
  margin-bottom: 1rem;
}
</style>
