<script setup lang="ts">
import PanoramaViewer from '@/components/PanoramaViewer.vue'

defineProps<{
  photo: 'interior' | 'exterior'
}>()
</script>

<template>
  <main class="panorama">
    <PanoramaViewer :photo="photo" />
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
