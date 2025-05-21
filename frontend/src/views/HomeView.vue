<script setup lang="ts">
import PanoramaViewer from '@/components/PanoramaViewer.vue'
</script>

<template>
  <main class="panorama">
    <PanoramaViewer />
  </main>
</template>

<style>
.panorama {
  flex: 1;
  position: relative;
  width: 100vw;
  overflow: hidden;
}
</style>
