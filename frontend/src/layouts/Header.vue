<!-- Header.vue -->
<template>
  <header class="bg-blue-50 p-4 flex justify-between items-center h-[10vh]">
    <!-- Conteúdo do cabeçalho vai aqui -->
    <img src="../assets/img/logo.png" class="w-16" />
  </header>
</template>

<script>
import cookie from "../services/cookie";
export default {
  name: "Header",
  methods: {},
};
</script>

<style scoped>
.primary-color {
  background-color: #1b4b73;
}
</style>
