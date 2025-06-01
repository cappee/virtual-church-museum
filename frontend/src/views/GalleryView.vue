<template>
  <div class="container">
    <input type="search" v-model="search" placeholder="Cerca un'opera" />

    <div class="grid">
      <article v-for="work in filteredWorks" :key="work.title">
        <img :src="work.images[0]" :alt="work.title" class="work-image" loading="lazy" />
        <div class="work-info">
          <h4 class="work-title">
            <a :href="`/opera/${work.id}`">{{ work.title }}</a>
          </h4>
          <p v-if="work.subtitle" class="work-subtitle">
            {{ work.subtitle }}
          </p>
        </div>
      </article>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'

const works = ref([])
const search = ref('')

onMounted(() => {
  fetch('http://localhost:8000/api/works.php?action=list')
    .then((res) => res.json())
    .then((data) => {
      works.value = data
    })
})

const filteredWorks = computed(() =>
  works.value.filter((work) => work.title.toLowerCase().includes(search.value.toLowerCase())),
)
</script>

<style scoped>
.container {
  margin-top: 2rem;
}

.search-bar {
  display: block;
  margin: 2rem auto;
  max-width: 400px;
}

.grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
  gap: 1.5rem;
  margin-top: 1rem;
}

.work-image {
  width: 100%;
  height: 250px;
  object-fit: cover;
  border-radius: 0.5rem;
}

.work-info {
  margin-top: 0.5rem;
}

.work-title {
  margin: 0;
}

.work-subtitle {
  color: grey;
  margin: 0.25rem 0 0;
}

article {
  padding: 1rem;
  border: 1px solid var(--pico-primary);
  border-radius: 0.5rem;
  text-align: center;
}

a {
  --pico-text-decoration: none;
  --pico-underline: var(--pico-primary);
}
</style>
