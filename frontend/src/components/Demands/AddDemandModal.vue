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
          <h2 class="text-2xl font-semibold mb-4">Adicionar nova demanda</h2>
          <label for="title">Título</label>
          <input
            v-model="demand.title"
            type="text"
            id="title"
            class="bg-gray-300 py-1 px-2 placeholder-gray-500 text-gray-700 font-light rounded-sm focus:outline-none block w-full mb-2"
          />

          <label for="description">Descrição</label>
          <input
            v-model="demand.description"
            type="text"
            id="description"
            class="bg-gray-300 py-1 px-2 placeholder-gray-500 text-gray-700 font-light rounded-sm focus:outline-none block w-full mb-2"
          />

          <label for="deadline">Prazo</label>
          <input
            v-model="demand.deadline"
            type="date"
            id="deadline"
            class="bg-gray-300 py-1 px-2 placeholder-gray-500 text-gray-700 font-light rounded-sm focus:outline-none block w-full mb-2"
          />

          <label for="customer">Cliente</label>
          <v-select
            v-model="demand.customer"
            :options="$pinia.state.value.customer.customers"
            label="name"
            id="customer"
            class="bg-gray-300 mb-2"
            @update:modelValue="console.log(demand.customer?.id)"
          />

          <label for="teams">Times envolvidos</label>
          <v-select
            v-model="demand.teams"
            :options="$pinia.state.value.team.teams"
            label="name"
            multiple
            id="teams"
            class="bg-gray-300 mb-2"
            @update:modelValue="handleAddTeam"
            @remove="handleRemoveTeam"
            appendToBody 
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
            @click="createDemand"
            class="px-4 py-2 bg-blue-500 text-white rounded-md"
          >
            Salvar
          </button>
        </div>
        <!-- <button @click="console.log()">route</button> -->
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import api from "../../services/api";
import { useApplicationStore } from "../../stores/ApplicationStore";
import { useDemandStore } from "../../stores/DemandStore";
import { useTeamStore } from "../../stores/TeamStore";
import vSelect from "vue-select";
import "vue-select/dist/vue-select.css";
import { Demand } from "../../types/Demand";
import { DemandStatus } from "../../types/Enums";

const demandStore = useDemandStore();
const teamStore = useTeamStore();
export default {
  name: "AddDemandModal",
  components: {
    vSelect,
  },
  data() {
    const defaultTeam = this.$pinia.state.value.demand.teamWithDemands;

    return {
      isOpen: false,
      demand: {
        id: "",
        title: "",
        description: "",
        status: "",
        deadline: null,
        customer: this.$pinia.state.value.demand.customerWithDemands ?? [],
        teams:
          Object.keys(this.$pinia.state.value.demand.teamWithDemands).length ===
          0
            ? []
            : [this.$pinia.state.value.demand.teamWithDemands],
        tasks: [],
      } as unknown as Demand,
    };
  },
  methods: {
    openModal() {
      this.isOpen = true;
    },

    closeModal() {
      this.isOpen = false;
    },

    createDemand() {
      useApplicationStore().setIsLoading(true);
      const payload = {
        title: this.demand.title,
        description: this.demand.description,
        status: DemandStatus.Pending,
        deadline: this.demand.deadline,
        customer_id: this.demand!.customer.id,
        teams_ids: this.demand!.teams.map((team) => team.id),
      };

      api
        .post("demands", payload)
        .then((response) => {
          const currentDemands = demandStore.demands;
          currentDemands?.push(response.data.data);
          demandStore.storeDemands(currentDemands);

          // if (this.$route.name === "demandsForCustomer") {
          //   api
          //     .get(`demands/customer/${response.data.data.customer.id}`)
          //     .then((response) => {
          //       demandStore.storeDemands(response.data.data);
          //       console.log(response.data.data[0].customer);
          //       this.$router
          //         .push({
          //           name: "demandsList",
          //           params: {
          //             id: response.data.data[0].customer?.id,
          //           },
          //         })
          //         .catch((e) => alert(e));
          //     });
          // }
          // else if (this.$route.name === "demandsForTeam") {
          //   api
          //     .get(`demands/team/${response.data.data.customer}`)
          //     .catch((e) => alert(e));
          //   this.$router.push({
          //     name: "demandsList",
          //     params: {
          //       id: response.data.data.customer.id,
          //     },
          //   });
          // }
        })
        .catch((e) => alert(e))
        .finally(() => {
          this.closeModal();
          useApplicationStore().setIsLoading(false);
        });
    },

    handleAddTeam() {
      teamStore.storeTeams(
        teamStore.teams.filter((team) => !this.demand.teams.includes(team))
      );

      console.log(this.demand.teams);
    },

    handleRemoveTeam(removedTeam) {
      // Adicionar o time removido de volta à lista de opções gerenciada pelo Pinia
      this.$pinia.state.value.team.teams.push(removedTeam);

      console.log(this.demand.teams);
    },
  },
  watch: {
    "demand.teams": function (newTeams, oldTeams) {
      // Identifica o time removido
      const removedTeam = oldTeams.find((team) => !newTeams.includes(team));

      if (removedTeam) {
        // Adiciona o time removido de volta à lista de opções gerenciada pelo Pinia
        this.$pinia.state.value.team.teams.push(removedTeam);
        // Ordena a lista alfabeticamente
        this.$pinia.state.value.team.teams.sort((a, b) =>
          a.name.localeCompare(b.name)
        );
      }
    },
  },
};
</script>

<style scoped>
/* Estilos específicos da modal aqui, se necessário */
</style>
