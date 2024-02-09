<template>
  <div>
    <div class="flex justify-between mb-4 items-center">
      <h2 class="text-xl mb-8">Times</h2>
      <button
        @click="openModal()"
        class="rounded px-3 py-2 bg-blue-600 text-white hover:bg-blue-800 hover:transition-all"
      >
        Adicionar Time
      </button>
    </div>

    <ul class="grid grid-cols-5 gap-4 max-h-[70vh] overflow-auto">
      <li
        v-for="(team, index) in $pinia.state.value.team.teams"
        :key="index"
        class="bg-[#1B4B73] rounded my-2 p-4 text-white"
      >
        <div class="flex justify-between">
          <h3 class="text-lg mb-3">
            {{ team.name }}
          </h3>
          <ActionIconMenu :team="team" />
        </div>
        <p v-for="user in team.users">{{ user.full_name }}</p>
      </li>
    </ul>

    <Modal ref="modal" />
  </div>
</template>

<script>
import api from "../services/api";
import { useTeamStore } from "../stores/TeamStore";
import Modal from "../components/Teams/AddTeamModal.vue";
import ActionIconMenu from "../components/Teams/ActionIconMenu.vue";
import { useApplicationStore } from "../stores/ApplicationStore";
import { useUserStore } from "../stores/UserStore";

const teamStore = useTeamStore();
export default {
  name: "Teams",

  components: {
    ActionIconMenu,
    Modal,
  },

  data() {
    return {};
  },

  created() {
    this.getTeams();
    this.getUsers();
  },

  methods: {
    getTeams() {
      useApplicationStore().setIsLoading(true);
      api
        .get("teams")
        .then((response) => {
          teamStore.storeTeams(response.data.data);
        })
        .catch((e) => alert(e))
        .finally(() => useApplicationStore().setIsLoading(false));
    },

    getUsers() {
      useApplicationStore().setIsLoading(true);
      api
        .get("me/all")
        .then((response) => {
          useUserStore().storeUsers(response.data.data);
          teamStore.storeUsersToAdd(response.data.data);
        })
        .catch((e) => alert(e))
        .finally(() => useApplicationStore().setIsLoading(false));
    },

    openModal() {
      this.$refs.modal.openModal();
    },
  },
};
</script>

<style></style>
