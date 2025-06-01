<script setup>
import { ref, computed } from 'vue'
import { useRoute, RouterView } from 'vue-router'
import { Globe, Amphora, LibraryBig } from 'lucide-vue-next'

const route = useRoute()

// Con queste variabili possiamo determintare quale pagina è attualmente attiva
const isTour = computed(() => route.path === '/')
const isMuseum = computed(() => route.path === '/museum' || route.name === 'opera')
const isAbout = computed(() => route.path === '/about')

const selectedPhoto = ref('interior')
</script>

<template>
  <div class="app">
    <header class="container-fluid">
      <nav>
        <ul>
          <li class="title">Basilica di San Giovanni in Porta Latina</li>
          <li class="select-container" v-if="isTour">
            <select v-model="selectedPhoto">
              <option value="interior">Interno</option>
              <option value="exterior">Esterno</option>
            </select>
          </li>
        </ul>
        <ul>
          <li>
            <a href="/" :class="{ active: isTour }"
              ><Globe class="icon"></Globe><span class="nav-text">Tour 360°</span></a
            >
          </li>
          <li>
            <a href="/museum" :class="{ active: isMuseum }"
              ><Amphora class="icon"></Amphora><span class="nav-text">Opere</span></a
            >
          </li>
          <li>
            <a href="/about" :class="{ active: isAbout }"
              ><LibraryBig class="icon"></LibraryBig><span class="nav-text">Storia</span></a
            >
          </li>
        </ul>
      </nav>
    </header>
    <RouterView :photo="selectedPhoto" />
  </div>
</template>

<style>
:root {
  --pico-primary: rgb(243, 203, 165) !important;
  --pico-primary-hover: rgb(151, 90, 94) !important;
}

header {
  position: sticky;
  top: 0;
  z-index: 10;
  background-color: rgba(37, 22, 27, 0.9);
  backdrop-filter: blur(15px);
}

header select {
  background-color: rgba(255, 255, 255, 0.1);
  color: white;
  border: none;
  appearance: none;
}

header select option {
  background-color: rgba(37, 22, 27, 0.95); /* colore scuro visibile */
  color: white;
}

header select option:focus {
  outline: none;
  background-color: rgba(37, 22, 27, 1); /* Evita effetto grigio su focus */
}

.title {
  font-family: 'Figtree', sans-serif;
  font-size: 1.4em;
  color: white;
}

.icon {
  width: 1rem;
  height: 1rem;
  vertical-align: middle;
  margin-right: 0.3em;
  margin-bottom: 0.2em;
}

a {
  font-family: 'Inter', sans-serif;
}

a.active {
  text-decoration: underline !important;
}

a:hover {
  text-decoration: none !important;
}

@media (max-width: 600px) {
  /* Stile per visualizzazione da cellulare */
  .title {
    font-size: 0.9rem;
  }
  .nav-text {
    display: none;
  }
  header select {
    font-size: 0.8rem;
  }
  .select-container {
    width: 100%;
  }
}
</style>
