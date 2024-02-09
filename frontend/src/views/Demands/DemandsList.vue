<template>
  <div class="">
    <div class="flex justify-between mb-4">
      <h1 class="text-center font-bold text-2xl">Demandas de {{ $pinia.state.value.demand.customerWithDemands.name ?? $pinia.state.value.demand.teamWithDemands.name }}</h1>
      <button
        @click="openModal()"
        class="rounded px-3 py-2 bg-blue-600 text-white hover:bg-blue-800 hover:transition-all"
      >
        Adicionar demanda
      </button>
    </div>
    <DemandAccordion v-if="$pinia.state.value.demand.demands" />
    <img
      v-else
      src="../../assets/img/spinner.svg"
      alt=""
      class="w-5 h-5 mr-2"
    />
    <Modal ref="modal" />
  </div>
</template>

<script>
import CardTeam from "../../components/Demands/CardTeam.vue";
import Modal from "../../components/Demands/AddDemandModal.vue";
import { useDemandStore } from "../../stores/DemandStore";
import DemandAccordion from "../../components/Demands/DemandAccordion.vue";
import { TaskStatus } from "../../types/Enums";

const demandStore = useDemandStore();
export default {
  name: "DemandsList",
  components: {
    Modal,
    CardTeam,
    DemandAccordion,
  },

  data() {
    return {
      spinner: {
        load_demands: false,
      },
    };
  },
  created() {
    // this.getDemandsByTeam();
  },

  methods: {
    openModal() {
      this.$refs.modal.openModal();
    },
    
    // getTaskColor(task: Task, index) {
    getTaskColor(task, index) {
      if (task.status === TaskStatus.Completed) {
        return "bg-green-400";
      } else if (task.status === TaskStatus.AwaitingApproval) {
        return "bg-yellow-400";
      } else if (new Date(task.deadline) > new Date()) {
        return "bg-blue-300";
      } else {
        return "bg-red-400";
      }
    },
  },
};
</script>

<style></style>
