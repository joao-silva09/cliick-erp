<template>
  <nav class="w-full p-2">
    <ul v-if="$route.matched[1].path === '/customers'" class="flex gap-2">
      <HeaderLinks :routeName="'customers'" routeLabel="Todos" />
    </ul>
    <ul v-if="$route.matched[1].path === '/demands'" class="flex gap-2">
      <HeaderLinks :routeName="'overview'" routeLabel="Visão Geral" />
      <HeaderLinks :routeName="'myTasks'" routeLabel="Minhas Tarefas" />
      <HeaderLinks :routeName="'completedTasks'" routeLabel="Concluídas" />
      <HeaderLinks :routeName="'demandsForTeam'" routeLabel="Por Time" />
      <HeaderLinks :routeName="'demandsForCustomer'" routeLabel="Por Cliente" />
    </ul>
    <ul v-if="$route.matched[1].path === '/financial'" class="flex gap-2">
      <HeaderLinks :routeName="'demandsForTeam'" routeLabel="Geral" />
      <HeaderLinks :routeName="'demandsForTeam'" routeLabel="Despesas" />
      <HeaderLinks :routeName="'demandsForTeam'" routeLabel="Dívidas" />
    </ul>
    <!-- <div v-else @click.stop.prevent="back()">  
<router-link :to="this.$router.back()">Voltar</router-link> 
      Voltar
    </div> -->
  </nav>
</template>

<script>
import HeaderLinks from "../components/Layout/HeaderLinks.vue";
import { useUserStore } from "../stores/UserStore";

export default {
  name: "NavHeader",
  components: {
    HeaderLinks,
  },

  data() {
    return {
      //   routes: {
      //     demands: [
      //       {
      //         name: "perTeam",
      //         route: "/per-team",
      //       },
      //       {
      //         name: "perCustomer",
      //         route: "/per-customer",
      //       },
      //     ],
      //   },
    };
  },

  mounted() {
    console.log(this.$route);
  },
  methods: {},
  watch: {
    $route() {
      useUserStore().storeCurrentRouteName(this.$route?.matched[2]?.name);
    },
  },
};
</script>

<style></style>
