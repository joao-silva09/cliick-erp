<template>
  <div style="height: 300px">
    <div class="flex justify-between mb-4 items-center">
      <h2 class="text-xl mb-8">Clientes</h2>
      <button
        @click="openModal()"
        class="rounded px-3 py-2 bg-blue-600 text-white hover:bg-blue-800 hover:transition-all"
      >
        Adicionar Cliente
      </button>
    </div>
    <ul class="grid grid-cols-6 gap-3">
      <li
        v-for="customer in $pinia.state.value.customer.customers"
        :key="customer.id"
        class="bg-gray-200 rounded shadow-xl my-2 p-4"
      >
        {{ customer.name }} - {{ customer.email }} - {{ customer.entry_date }}
      </li>
    </ul>

    <Modal ref="modal" />
  </div>
</template>

<script>
import api from "../services/api";
import { useCustomerStore } from "../stores/CustomerStore";
import Modal from "../components/Customers/AddCustomerModal.vue";
import { useApplicationStore } from "../stores/ApplicationStore";
const store = useCustomerStore();

export default {
  name: "Customers",

  components: {
    Modal,
  },

  data() {
    return {};
  },

  created() {
    store.getCustomers();
  },

  methods: {
    openModal() {
      this.$refs.modal.openModal();
    },
  },
};
</script>

<style></style>
