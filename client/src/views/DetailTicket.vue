<script setup>
import { ref, onBeforeMount } from 'vue';
import axios from 'axios';
import { useRouter, useRoute } from 'vue-router'

const ticketApi = import.meta.env.VITE_TICKET_API_URL;
const orderApi = import.meta.env.VITE_ORDER_API_URL;

const router = useRouter();
const route = useRoute();
const ticketId = route.params.id
const ticket =  ref(null);

const formData = ref({
    name: '',
    price: '',
})

onBeforeMount(async () => {
    axios.get(`${ticketApi}/${ticketId}/detail`)
        .then((res) => {
            ticket.value = res.data.data;
        });
});

const onMakePurchase = () => {
    axios.post(`${orderApi}/create`, {
      ticket_id: ticketId,
      amount: parseFloat(ticket.value.price)
    })
        .then((res) => {
          const orderId = res.data.data.id;
          router.push({name: 'order', params: { id: orderId }})
        });
}

</script>

<template>
  <div>
    <h2>Detail</h2>
    <div v-if="ticket">
      <p>
        Name: {{ ticket.name }}
      </p>
      <p>
        Price: {{ ticket.price }}
      </p>
      <button type="button" class="btn btn-primary" @click="onMakePurchase">Make Purchase</button>
    </div>
  </div>
</template>
