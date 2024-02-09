<!-- ActionIconMenu.vue -->
<template>
  <div class="action-icon" @click="toggleMenu">
    <!-- Ícone de ações (use uma biblioteca de ícones, como FontAwesome) -->
    <div class="icon">&#9776;</div>

    <!-- Menu suspenso de ações -->
    <div v-if="isMenuOpen" class="action-menu menu-left">
      <div class="action-menu-item" @click="handleOpenAddUserModal()">
        Adicionar Usuários
      </div>
      <div class="action-menu-item" @click="performAction('Option 2')">
        Excluír time
      </div>
    </div>
    <AddUserModal ref="AddUserModal" :team="$props.team" />
  </div>
</template>

<script lang="ts">
import AddUserModal from "./AddUserModal.vue";
import { Team } from "../../types/team";

export default {
  data() {
    return {
      isMenuOpen: false,
      isAddUserModalOpen: false,
      isDeleteTeamModalOpen: false,
    };
  },

  props: {
    team: {} as Team,
  },

  components: {
    AddUserModal,
  },

  methods: {
    toggleMenu() {
      this.isMenuOpen = !this.isMenuOpen;
    },

    performAction(option) {
      // Implemente a lógica para cada opção do menu
      console.log("Ação realizada:", option);
      this.isMenuOpen = false; // Fechar o menu após ação
    },

    handleOpenAddUserModal() {
      this.$refs.AddUserModal.openModal();
    },
  },
};
</script>

<style scoped>
/* Adicione estilos conforme necessário */
.action-icon {
  position: relative;
  cursor: pointer;
}

.icon {
  /* Estilos para o ícone de ações */
}

.action-menu {
  position: absolute;
  left: 0;
  top: 100%;
  width: 160px;
  display: none;
  background-color: #fff;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
  z-index: 1;
}

.action-icon:hover .action-menu {
  display: block;
}

.action-menu-item {
  padding: 10px;
  cursor: pointer;
  user-select: none;
  color: black;
}

.action-menu-item:hover {
  background-color: #f0f0f0;
}
</style>
