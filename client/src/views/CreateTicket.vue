<script setup>
import { ref } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router'

const ticketApi = import.meta.env.VITE_TICKET_API_URL;

const router = useRouter();
const tickets =  ref([]);

const formData = ref({
    name: '',
    price: '',
})

const onSubmit = (event) => {
    event.preventDefault();

    axios.post(`${ticketApi}/create`, formData.value)
        .then((res) => {
            console.log(res.data);
            router.push('/tickets');
        });
}

</script>

<template>
  <div>
    <h2>Create New Ticket</h2>
    <form>
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" v-model="formData.name" required class="form-control" id="name">
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="text" v-model="formData.price" class="form-control" id="price">
        </div>
        <button type="submit" required class="btn btn-primary" @click="onSubmit">Submit</button>
    </form>
  </div>
</template>
