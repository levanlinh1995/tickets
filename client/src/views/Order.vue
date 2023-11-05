<script setup>
import { ref, onBeforeMount } from 'vue';
import axios from 'axios';
import { useRouter, useRoute } from 'vue-router'

import moment from 'moment'

const orderApi = import.meta.env.VITE_ORDER_API_URL;
const paymentApi = import.meta.env.VITE_PAYMENT_API_URL;

const router = useRouter();
const route = useRoute();
const OrderId = route.params.id
const order =  ref(null);
const isExpired = ref(false);
const secDiff = ref(0);

const formData = ref({
    name: '',
    price: '',
})

onBeforeMount(async () => {
    axios.get(`${orderApi}/${OrderId}/detail`)
        .then((res) => {
          order.value = res.data.data;

          const now = moment.utc();
          const expireDate = moment.utc(order.value.expired_at);

          secDiff.value = expireDate.diff(now, 'seconds');
          if (secDiff.value <= 0) {
            isExpired.value = true;
          }

          countDownTimer();
        });
});

const countDownTimer = () => {
    if (secDiff.value > 0) {
        setTimeout(() => {
          secDiff.value -= 1
          countDownTimer()
        }, 1000)
    }
  };

const onPay = () => {
    axios.post(`${paymentApi}/create`, {
      order_id: OrderId,
      stripe_token: '453453453453434'
    })
        .then((res) => {
          router.push({name: 'tickets'})
        });
}

</script>

<template>
  <div>
    <h2>Purchase</h2>
    <div v-if="order">
      <p>
        Amount: {{ order.amount }}
      </p>
      <p v-if="isExpired">Expired</p>
      <p v-else>Count Down: {{ secDiff }}</p>
      <button :disabled="isExpired" type="button" class="btn btn-primary" @click="onPay">Pay</button>
    </div>
  </div>
</template>
