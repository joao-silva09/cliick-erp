<template>
  <router-link :to="{ name: $props.routeName }">
    <li
      :class="routeName === currentRouteName ? 'border-blue-700' : ''"
      class="py-0.5 px-2 border-2 border-gray-400 rounded hover:border-blue-600"
    >
      {{ routeLabel }}
    </li>
  </router-link>
</template>

<script lang="ts">
import { useUserStore } from "../../stores/UserStore";

const userStore = useUserStore();
export default {
  name: "HeaderLinks",
  props: {
    routeName: String,
    routeLabel: String,
  },
  data() {
    return {};
  },
  computed: {
    currentRouteName(): string {
      return userStore.currentRouteName;
    },
  },
};
</script>

<style></style>
