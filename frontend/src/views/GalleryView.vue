<template>
  <div class="container" style="margin-top: 2rem">
    <input type="search" v-model="search" placeholder="Cerca un'opera" />

    <div class="grid" style="margin-top: 1rem">
      <article v-for="work in filteredWorks" :key="work.title">
        <img
          :src="work.image"
          :alt="work.title"
          style="width: 100%; height: auto; border-radius: 0.5rem"
        />
        <h4 style="margin-top: 0.5rem">
          <a :href="`/opera/${work.id}`">{{ work.title }}</a>
        </h4>
      </article>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'

const works = ref([])
const search = ref('')

onMounted(async () => {
  const res = await fetch('http://localhost:8000/api/works.php?action=list')
  works.value = await res.json()
})

const filteredWorks = computed(() =>
  works.value.filter((work) => work.title.toLowerCase().includes(search.value.toLowerCase())),
)
</script>

<style scoped>
.search-bar {
  display: block;
  margin: 2rem auto;
  max-width: 400px;
}

.grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
  gap: 1.5rem;
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
