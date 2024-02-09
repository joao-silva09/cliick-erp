<template>
  <div style="height: 300px">
    <h1 class="text-center mt-5">Financeiro</h1>

    <ul>
      <li v-for="team in teams" :key="team.id" class="bg-gray-100 my-2">
        {{ team.name }} - {{ team.email }} - {{ team.entry_date }}
      </li>
    </ul>

    <button
      @click="openModal()"
      class="px-4 py-2 bg-blue-500 text-white rounded-md"
    >
      Adicionar Time
    </button>

    <Modal ref="modal" />
  </div>
</template>

<script>
import api from "../services/api";
import { useTeamStore } from "../stores/TeamStore";
import Modal from "../components/Teams/AddTeamModal.vue";

const teamStore = useTeamStore();
export default {
  name: "Financial",

  components: {
    Modal,
  },

  data() {
    return {
      teams: [],
    };
  },

  created() {
    this.getTeams();
  },

  methods: {
    getTeams() {
      api.get("teams").then((response) => {
        this.teams = response.data.data;
        teamStore.storeTeams(response.data.data);
      });
    },

    openModal() {
      this.$refs.modal.openModal();
    },
  },
};
</script>

<style></style>
