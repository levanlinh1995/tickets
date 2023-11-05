<script setup>
import { RouterLink, RouterView } from 'vue-router'
</script>

<template>
  <header class="container">
    <ul class="nav">
      <li class="nav-item">
        <RouterLink to="/" class="nav-link active">Home</RouterLink>
      </li>
      <li class="nav-item">
        <RouterLink to="/tickets" class="nav-link active">Tickets</RouterLink>
      </li>
      <li class="nav-item">
        <RouterLink to="/" class="nav-link">Register</RouterLink>
      </li>
      <li class="nav-item">
        <RouterLink to="/" class="nav-link">Login</RouterLink>
      </li>
      <li class="nav-item">
        <RouterLink to="/" class="nav-link">Logout</RouterLink>
      </li>
    </ul>
  </header>
  <main class="container">
    <div>
      <RouterView />
    </div>
  </main>
</template>

<style scoped>
</style>
