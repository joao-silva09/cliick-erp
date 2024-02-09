<!-- LoadingOverlay.vue -->
<template>
  <div
    v-if="$pinia.state.value.application.isLoading"
    class="loading-overlay flex flex-col"
  >
    <!-- Seu conteúdo de carregamento aqui (por exemplo, um spinner) -->
    <div></div>
    <div class="spinner"></div>
    <img src="../../assets/img/logo.png" alt="" class="w-64" />
  </div>
</template>

<script>
import { useApplicationStore } from "../../stores/ApplicationStore";

const applicationStore = useApplicationStore();
export default {
  name: "LoadingOverlay",
};
</script>

<style scoped>
.loading-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(255, 255, 255, 0.8);
  display: flex;
  justify-content: space-evenly;
  align-items: center;
  z-index: 1000;
}

.spinner {
  border: 4px solid rgba(0, 0, 0, 0.1);
  border-left: 4px solid #1b4b73;
  border-radius: 50%;
  width: 40px;
  height: 40px;
  animation: spin 1s linear infinite;
}

@keyframes spin {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}
</style>
