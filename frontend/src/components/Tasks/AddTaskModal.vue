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
          <h2 class="text-2xl font-semibold mb-4">Adicionar nova tarefa</h2>
          <label for="title">Título</label>
          <input
            v-model="task.title"
            type="text"
            id="title"
            class="bg-gray-300 py-1 px-2 placeholder-gray-500 text-gray-700 font-light rounded-sm focus:outline-none block w-full"
          />

          <label for="description">Descrição</label>
          <input
            v-model="task.description"
            type="text"
            id="description"
            class="bg-gray-300 py-1 px-2 placeholder-gray-500 text-gray-700 font-light rounded-sm focus:outline-none block w-full"
          />

          <label for="deadline">Prazo</label>
          <input
            v-model="task.deadline"
            type="date"
            id="deadline"
            class="bg-gray-300 py-1 px-2 placeholder-gray-500 text-gray-700 font-light rounded-sm focus:outline-none block w-full"
          />

          <label for="usersIds">Usuários</label>
          <v-select
            v-model="task.users"
            :options="$pinia.state.value.demand.usersToAdd"
            label="name"
            multiple
            class="bg-gray-300"
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
            @click="createTasks"
            class="px-4 py-2 bg-blue-500 text-white rounded-md"
          >
            Salvar
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import api from "../../services/api";
import vSelect from "vue-select";
import "vue-select/dist/vue-select.css";
import { useUserStore } from "../../stores/UserStore";
import { useDemandStore } from "../../stores/DemandStore";
// import { Task } from "../../types/Task";
import { useApplicationStore } from "../../stores/ApplicationStore";
import { TaskStatus } from "../../types/Enums";

const userStore = useUserStore();
const demandStore = useDemandStore();
export default {
  name: "AddTaskModal",
  components: {
    vSelect,
  },
  props: {
    demandId: Number,
    demandIndex: Number,
  },
  data() {
    return {
      isOpen: false,
      task: {
        title: "",
        description: "",
        deadline: null,
        users: [],
      },
    };
  },
  methods: {
    openModal() {
      this.isOpen = true;
    },

    closeModal() {
      this.isOpen = false;
    },

    createTasks() {
      useApplicationStore().setIsLoading(true);
      const payload = {
        title: this.task.title,
        description: this.task.description,
        status: TaskStatus.Pending,
        deadline: this.task.deadline,
        demand_id: this.$props.demandId,
        users_ids: [
          userStore.user.id,
          ...this.task.users.map((user) => user.id),
        ],
      };

      console.log(demandStore.demandIndex);

      api
        .post("tasks", payload)
        .then((response) => {
          // const taskList: any[] =
          //   demandStore.demands![
          const taskList =
            demandStore.demands[
              Number(demandStore.demandIndex)
            ].tasks ?? [];
          taskList.push(response.data.data);
          demandStore.storeTasks(taskList);
        })
        .catch((e) => console.log(e))
        .finally(() => {
          this.closeModal();
          useApplicationStore().setIsLoading(false);
        });
    },
  },
};
</script>

<style scoped></style>
