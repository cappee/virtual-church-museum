import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '@/views/HomeView.vue'
import WorkView from '@/views/WorkView.vue'
import AboutView from '@/views/AboutView.vue'
import GalleryView from '@/views/GalleryView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'tour',
      component: HomeView,
    },
    { name: 'opera', path: '/opera/:id', component: WorkView, props: true },
    { path: '/museum', component: GalleryView },
    { path: '/about', component: AboutView },
  ],
})

export default router
