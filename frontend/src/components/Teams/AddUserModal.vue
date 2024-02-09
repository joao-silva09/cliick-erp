<!-- Modal.vue -->
<template>
  <div v-if="isOpen" class="fixed inset-0 overflow-y-auto z-10">
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
          <h2 class="text-2xl font-semibold mb-4">
            Adicionar Usuários Ao Time {{ $props.team.name }}
          </h2>

          <label for="users">Usuários</label>
          <v-select
            v-model="users"
            :options="$pinia.state.value.team.usersToAdd"
            label="full_name"
            class="bg-gray-300 mb-2"
            multiple
            id="users"
            @update:modelValue="handleAddUser"
            @remove="handleRemoveUser"
            appendToBody
          />
        </div>

        <!-- Botão para fechar a modal -->
        <div class="p-4 flex justify-end gap-2">
          <button
            @click="console.log(users)"
            class="px-4 py-2 bg-red-500 text-white rounded-md"
          >
            testtets
          </button>
          <button
            @click="closeModal"
            class="px-4 py-2 bg-red-500 text-white rounded-md"
          >
            Fechar
          </button>
          <button
            @click="createTeam"
            class="px-4 py-2 bg-blue-500 text-white rounded-md"
          >
            Salvar
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import api from "../../services/api";
import vSelect from "vue-select";
import "vue-select/dist/vue-select.css";
import { useTeamStore } from "../../stores/TeamStore";
import { useApplicationStore } from "../../stores/ApplicationStore";
import { Team } from "../../types/team";

const teamStore = useTeamStore();
export default {
  name: "AddUserModal",

  components: {
    vSelect,
  },

  data() {
    return {
      isOpen: false,
      users: [],
    };
  },

  props: {
    team: {} as any,
  },

  methods: {
    openModal() {
      this.isOpen = true;
      teamStore.storeUsersToAdd(
        this.compararArraysDeObjetos(
          this.$pinia.state.value.team.usersToAdd,
          this.$props.team.users
        )
      );
    },

    closeModal() {
      this.isOpen = false;
      teamStore.storeUsersToAdd(this.$pinia.state.value.user.users);
    },

    createTeam() {
      useApplicationStore().setIsLoading(true);

      const payload = {
        users_ids: this.users.map((user) => user.id),
      };

      console.log(payload.users_ids);

      api
        .post(`teams/${this.$props.team.id}/add-users`, payload)
        .then((response) => {
          const currentTeams = teamStore.teams;
          currentTeams[this.$props.team.id].users!.push(
            response.data.data.users
          );
          teamStore.storeTeams(currentTeams);
        })
        .catch((e) => console.log(e))
        .finally(() => {
          useApplicationStore().setIsLoading(false);
          this.closeModal();
        });

    },

    handleAddUser() {
      teamStore.storeUsersToAdd(
        teamStore.usersToAdd.filter((user) => !this.users.includes(user))
      );

      console.log(this.users);
    },

    handleRemoveUser(removedTeam) {
      // Adicionar o user removido de volta à lista de opções gerenciada pelo Pinia
      this.$pinia.state.value.team.usersToAdd.push(removedTeam);
    },

    compararArraysDeObjetos(array1, array2) {
      // Usa a função filter para retornar apenas os objetos que não estão em array2
      const resultado = array1.filter((objeto1) => {
        // Verifica se o objeto não está presente em array2
        return !array2.some((objeto2) =>
          this.compararObjetos(objeto1, objeto2)
        );
      });

      return resultado;
    },

    // Função auxiliar para comparar objetos
    compararObjetos(objeto1, objeto2) {
      // Implemente a lógica de comparação de objetos conforme necessário
      // Aqui é um exemplo simples, você pode ajustar conforme seus requisitos
      return objeto1.id === objeto2.id;
    },
  },

  watch: {
    users: function (newUsers, oldUsers) {
      // Identifica o usuário removido
      const removedUser = oldUsers.find((user) => !newUsers.includes(user));

      if (removedUser) {
        // Adiciona o usuário removido de volta à lista de opções gerenciada pelo Pinia
        this.$pinia.state.value.team.usersToAdd.push(removedUser);
        // Ordena a lista alfabeticamente
        this.$pinia.state.value.team.usersToAdd.sort((a, b) =>
          a.full_name.localeCompare(b.full_name)
        );
      }
    },
  },
};
</script>

<style scoped>
/* Estilos específicos da modal aqui, se necessário */
</style>
