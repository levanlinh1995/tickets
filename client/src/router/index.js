import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView
    },
    {
      path: '/tickets',
      name: 'tickets',
      component: () => import('../views/Tickets.vue')
    },
    {
      path: '/tickets/create',
      name: 'tickets_create',
      component: () => import('../views/CreateTicket.vue')
    },
    {
      path: '/tickets/:id/detail',
      name: 'ticket_detail',
      component: () => import('../views/DetailTicket.vue')
    },
    {
      path: '/order/:id',
      name: 'order',
      component: () => import('../views/Order.vue')
    }
  ]
})

export default router
