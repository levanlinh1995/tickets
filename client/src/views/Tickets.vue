<script setup>
import { ref, onBeforeMount } from 'vue';
import { RouterLink } from 'vue-router'
import axios from 'axios';

const ticketApi = import.meta.env.VITE_TICKET_API_URL;

const tickets =  ref([]);

onBeforeMount(async () => {
    axios.get(`${ticketApi}/list`)
        .then((res) => {
            tickets.value = res.data.data;
        });
});

</script>

<template>
  <div>
    <h2>Tickets</h2>
    <div class="d-flex justify-content-end">
        <RouterLink to="/tickets/create">
            <button type="button" class="btn btn-primary">Create Ticket</button>
        </RouterLink>
    </div>
    
    <ul class="list-group list-group-flush">
        <li v-for="ticket in tickets" class="list-group-item" :key="ticket.id">
            <div v-if="ticket.status == 1">
                <RouterLink :to="{ name: 'ticket_detail', params: { id: ticket.id} }">{{ ticket.name }}</RouterLink>
                <span class="mx-5">Price: {{ ticket.price }}</span>
            </div>
        </li>
    </ul>
  </div>
</template>
