<!-- Modal.vue -->
<template>
  <div v-if="isOpen" class="fixed inset-0 overflow-y-auto">
    <div
      class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0"
    >
      <!-- Máscara de fundo -->
      <div class="fixed inset-0 transition-opacity" @click="closeModal">
        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
      </div>

      <!-- Conteúdo da modal -->
      <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>
      <!-- Alinha ao centro no sm -->
      &#8203;
      <div
        class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
      >
        <!-- Conteúdo interno da modal -->
        <div class="bg-white p-4">
          <h2 class="text-2xl font-semibold mb-4">Adicionar novo cliente</h2>
          <label for="name">Nome</label>
          <input
            v-model="customer.name"
            type="text"
            id="name"
            class="bg-gray-300 py-1 px-2 placeholder-gray-500 text-gray-700 font-light rounded-sm focus:outline-none block w-full"
          />

          <label for="email">Email</label>
          <input
            v-model="customer.email"
            type="email"
            id="email"
            class="bg-gray-300 py-1 px-2 placeholder-gray-500 text-gray-700 font-light rounded-sm focus:outline-none block w-full"
          />

          <label for="entry_date">Data de Entrada</label>
          <input
            v-model="customer.entryDate"
            type="date"
            id="entry_date"
            class="bg-gray-300 py-1 px-2 placeholder-gray-500 text-gray-700 font-light rounded-sm focus:outline-none block w-full"
          />
        </div>

        <!-- Botão para fechar a modal -->
        <div class="p-4 flex justify-end gap-2">
          <button
            @click="closeModal"
            class="px-4 py-2 bg-red-500 text-white rounded-md"
          >
            Fechar
          </button>
          <button
            @click="createCustomer"
            class="px-4 py-2 bg-blue-500 text-white rounded-md"
          >
            Salvar
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import api from "../../services/api";
import { useApplicationStore } from "../../stores/ApplicationStore";
import { useCustomerStore } from "../../stores/CustomerStore";

const customerStore = useCustomerStore();
export default {
  data() {
    return {
      isOpen: false,
      customer: {
        name: "",
        email: "",
        entryDate: "",
      },
    };
  },
  methods: {
    openModal() {
      this.isOpen = true;
    },

    closeModal() {
      this.isOpen = false;
    },

    createCustomer() {
      useApplicationStore().setIsLoading(true);
      const payload = {
        name: this.customer.name,
        email: this.customer.email,
        entry_date: this.customer.entryDate,
        company_id: 1,
      };

      api
        .post("customers", payload)
        .then((response) => {
          const currentCustomers = customerStore.customers;
          currentCustomers.unshift(response.data.data);
          customerStore.storeCustomers(currentCustomers);
        })
        .catch((e) => alert(e))
        .finally(() => useApplicationStore().setIsLoading(false));

      this.closeModal();
    },
  },
};
</script>

<style scoped>
/* Estilos específicos da modal aqui, se necessário */
</style>
