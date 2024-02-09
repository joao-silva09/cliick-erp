<template>
  <div style="height: 300px">
    <h1 class="text-center mt-5">Demandas</h1>

    <ul>
      <li
        v-for="demand in $pinia.state.value.demand.demands"
        :key="demand.id"
        class="bg-gray-100 my-2"
      >
        {{ demand.title }} - {{ demand.customer.name }} -
        {{ demand.teams.map((team) => team.name) }}
      </li>
    </ul>

    <button
      @click="openModal()"
      class="px-4 py-2 bg-blue-500 text-white rounded-md"
    >
      Adicionar demanda
    </button>

    <Modal ref="modal" />
  </div>
</template>

<script>
import { useDemandStore } from "../../stores/DemandStore";
import Modal from "../../components/Demands/AddDemandModal.vue";
const store = useDemandStore();

export default {
  name: "Demands",

  components: {
    Modal,
  },

  data() {
    return {
      demands: [],
    };
  },

  created() {
    store.getDemands();
  },

  methods: {
    // getDemands() {
    //   api.get("demands").then((response) => {
    //     this.demands = response.data.data;
    //     store.storeDemands(response.data.data);
    //   });
    // },

    openModal() {
      this.$refs.modal.openModal();
    },
  },
};
</script>

<style></style>
