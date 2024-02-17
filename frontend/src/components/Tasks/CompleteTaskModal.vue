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
          <h2 class="text-2xl font-semibold mb-4">Concluir tarefa</h2>
          <label for="solution">Solução</label>
          <textarea
            v-model="solution"
            type="text"
            id="solution"
            placeholder="Descreva a solução..."
            class="bg-gray-300 py-1 px-2 placeholder-gray-500 text-gray-700 font-light rounded-sm focus:outline-none block w-full"
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
            @click="completeTask"
            class="px-4 py-2 bg-blue-500 text-white rounded-md"
          >
            Concluir
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import api from "../../services/api";
import { useApplicationStore } from "../../stores/ApplicationStore";
import { useTaskStore } from "../../stores/TaskStore";
import { MessageTypeEnum } from "../../types/Enums";

const taskStore = useTaskStore();
export default {
  name: "CompleteTaskModal",
  components: {},
  props: {},
  data() {
    return {
      isOpen: false,
      solution: "",
    };
  },
  methods: {
    openModal() {
      this.isOpen = true;
    },

    closeModal() {
      this.isOpen = false;
    },

    completeTask() {
      useApplicationStore().setIsLoading(true);

      const payload = {
        message: this.solution,
      };

      api
        .post(`tasks/${taskStore.task.id}/complete`, payload)
        .then((response) => {
          const currentTasks = this.$pinia.state.value.task.task.messages;
          currentTasks.push(response.data.data);
          taskStore.storeMessage(currentTasks);
          console.log(currentTasks);

          taskStore.storeTaskStatus(MessageTypeEnum.Completed)
        })
        .catch((e) => alert(e))
        .finally(() => {
          useApplicationStore().setIsLoading(false);
          this.closeModal();
        });
    },
  },
};
</script>

<style scoped></style>
