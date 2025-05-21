<script setup lang="ts">
import { RouterView } from 'vue-router'
import { Globe, Amphora, LibraryBig } from 'lucide-vue-next'
</script>

<template>
  <div class="app">
    <header class="container-fluid">
      <nav>
        <ul>
          <li class="title">Basilica di San Giovanni in Porta Latina</li>
        </ul>
        <ul>
          <li>
            <a href="/"><Globe class="icon"></Globe>Tour</a>
          </li>
          <li>
            <a href="/museum"><Amphora class="icon"></Amphora>Opere</a>
          </li>
          <li>
            <a href="/about"><LibraryBig class="icon"></LibraryBig>Storia</a>
          </li>
        </ul>
      </nav>
    </header>
    <RouterView />
  </div>
</template>

<style>
body,
html {
  margin: 0;
  padding: 0;
  height: 100%;
}

:root {
  --pico-primary: rgb(243, 203, 165) !important;
  --pico-primary-hover: rgb(151, 90, 94) !important;
}

header {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  /*backdrop-filter: blur(15px);*/
  background-color: rgba(37, 22, 27);
  color: white;
  z-index: 10;
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
</style>
