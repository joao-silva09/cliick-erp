<template>
  <div
    v-for="(demand, index) in $pinia.state.value.demand.demands"
    :key="index"
    class="w-full my-2 rounded border border-gray-300"
  >
    <div
      @click="toggleItem(index)"
      class="p-2 bg-blue-100 cursor-pointer flex items-center justify-between"
    >
      <div class="flex gap-1">
        <div v-if="demand.customer?.name">[{{ demand.customer?.name }}]</div>
        <div v-if="demand.teams">
          [{{ demand.teams.map((team) => team.name).join(", ") }}]
        </div>
        {{ demand.title }}
      </div>
      <img
        v-if="demand.open"
        src="../../assets/icons/arrow-down-svgrepo-com.svg"
        alt=""
        class="w-5 h-5 mr-2"
      />
      <img
        v-else
        src="../../assets/icons/arrow-prev-small-svgrepo-com.svg"
        alt=""
        class="w-5 h-5 mr-2"
      />
    </div>

    <!-- Accordion Body -->
    <div v-show="demand.open" class="p-2 bg-white pb-5">
      <div class="flex justify-between mb-5">
        <p class="">
          Descrição:
          <b>
            {{ demand.description }}
          </b>
        </p>
        <p class="">
          Status:
          <b>
            {{ demand.status }}
          </b>
        </p>
        <p class="flex justify-end">
          Data de entrega:
          <b>
            {{ demand.deadline }}
          </b>
        </p>
      </div>
      <div class="flex justify-between">
        <h3 class="text-center font-bold">Tasks</h3>
        <button
          @click="openModal(index, demand.id)"
          class="rounded px-3 py-2 bg-blue-600 text-white hover:bg-blue-800 transition-all mb-4"
        >
          Adicionar Tarefa
        </button>
        <Modal ref="modal" :demand-id="demand.id" />
      </div>
      <div v-for="task in demand.tasks">
        <div
          :class="getTaskColor(task, index)"
          class="w-full border rounded border-gray-600 p-2 mb-2 bg-cyan-100 flex justify-between cursor-pointer hover:translate-x-2 hover:transition-all"
          @click.stop.prevent="getTask(task.id)"
        >
          <div>
            {{ task.demand?.customer?.name }}
            {{ task.title }}
          </div>
          <div class="flex gap-3">
            <div>
              {{ new Date(task.deadline).toLocaleDateString() }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import api from "../../services/api";
import { useDemandStore } from "../../stores/DemandStore";
import { useTaskStore } from "../../stores/TaskStore";
import Modal from "../Tasks/AddTaskModal.vue";
import { TaskStatus } from "../../types/Enums";
import { Task } from "../../types/Task";

const demandStore = useDemandStore();
const taskStore = useTaskStore();
export default {
  name: "DemandAccordion",
  components: {
    Modal,
  },
  data() {
    return {
      spinner: {
        load_demands: false,
      },
    };
  },
  methods: {
    toggleItem(index) {
      demandStore.demands[index].open = !demandStore.demands[index].open;
    },

    getTask(taskId) {
      taskStore.getTask(taskId, this.$router);
    },

    openModal(index, demandId) {
      this.$refs.modal[index].openModal();
      this.getUsersByTeamsOfDemands(demandId);
      demandStore.storeDemandIndex(index);
      console.log(demandStore.demandIndex);
    },

    getUsersByTeamsOfDemands(demandId) {
      api
        .get(`demands/users/${demandId}`)
        .then((response) => {
          const data = response.data.data.map((user) => ({
            ...user,
            name: `${user.first_name} ${user.last_name}`,
          }));
          demandStore.storeUsersToAdd(data);
        })
        .catch((e) => alert(e));
    },

    getTaskColor(task: Task, index) {
      if (task.status === TaskStatus.Completed) {
        return "bg-green-400";
      } else if (task.status === TaskStatus.AwaitingApproval) {
        return "bg-yellow-400";
      } else if (new Date(task.deadline) > new Date()) {
        return "bg-blue-300";
      } else {
        return "bg-red-400";
      }
    },
  },
};
</script>

<style></style>
