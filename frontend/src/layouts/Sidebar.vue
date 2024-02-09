<!-- Sidebar.vue -->
<template>
  <aside
    class="bg-white p-4 h-[90vh] w-[24vh] text-black font-semibold border-r border-blue-200"
  >
    <!-- Conteúdo do menu lateral vai aqui -->
    Olá, {{ userName }} <br /><br />
    <ul class="flex flex-col justify-between">
      <div class="flex flex-col gap-1.5 mt-2">
        <li
          class="hover:text-blue-700 flex gap-1.5 cursor-pointer items-center"
        >
          <HomeIcon class="h-5 w-5" />
          <router-link :to="{ name: 'home' }">Home</router-link>
        </li>
        <li
          class="hover:text-blue-700 flex gap-1.5 cursor-pointer items-center"
        >
          <BriefcaseIcon class="h-5 w-5" />
          <router-link :to="{ name: 'customers' }">Clientes</router-link>
        </li>
        <li
          class="hover:text-blue-700 flex gap-1.5 cursor-pointer items-center"
        >
          <UserGroupIcon class="h-5 w-5" />
          <router-link :to="{ name: 'teams' }">Times</router-link>
        </li>
        <li
          class="hover:text-blue-700 flex gap-1.5 cursor-pointer items-center"
        >
          <ClipboardDocumentCheckIcon class="h-5 w-5" />
          <router-link :to="{ name: 'overview' }">Demandas</router-link>
        </li>
        <li
          class="hover:text-blue-700 cursor-pointer flex gap-1.5 items-center"
        >
          <CurrencyDollarIcon class="h-5 w-5" />
          <router-link :to="{ name: 'financial' }">Financeiro</router-link>
        </li>
        <li class="hover:text-blue-700 cursor-pointer flex gap-1.5 items-center">
          <LogoutIcon class="h-5 w-5" />
          <div @click="logout()">Sair</div>
        </li>
      </div>
      <!-- Adicione mais itens de menu conforme necessário -->
    </ul>
  </aside>
</template>

<script>
import cookie from "../services/cookie";
import { useUserStore } from "../stores/UserStore";

import {
  BriefcaseIcon,
  ClipboardDocumentCheckIcon,
  CurrencyDollarIcon,
  HomeIcon,
  UserGroupIcon,
  ArrowLeftStartOnRectangleIcon as LogoutIcon,
} from "@heroicons/vue/24/outline";

const userStore = useUserStore();

export default {
  components: {
    CurrencyDollarIcon,
    ClipboardDocumentCheckIcon,
    UserGroupIcon,
    HomeIcon,
    BriefcaseIcon,
    LogoutIcon,
  },
  data() {
    return {
      userName: userStore.user.first_name,
    };
  },

  methods: {
    logout() {
      cookie.deleteToken();
      this.$router.push("/login");
    },
  },
};
</script>

<style scoped>
/* Estilos específicos para o menu lateral aqui */
</style>
