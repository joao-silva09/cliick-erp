<template>
  <div>
    <div class="flex justify-between items-center mb-3">
      <h2 class="text-xl">Minhas Tarefas</h2>
    </div>
    <div class="flex gap-3 flex-col">
      <div
        v-for="(task, index) in $pinia.state.value.task.tasks"
        :key="index"
        :class="getTaskColor(task, index)"
        class="w-full border rounded border-gray-600 p-2 bg-cyan-100 flex justify-between cursor-pointer hover:translate-x-2 hover:transition-all"
        @click.stop.prevent="getTask(task.id)"
      >
        <div>
          [{{ task.demand?.customer?.name }}]
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
</template>

<script>
import { useTaskStore } from "../../stores/TaskStore";
import { TaskStatus } from "../../types/Enums";

const taskStore = useTaskStore();
export default {
  name: "MyTasks",
  data() {
    return {};
  },

  created() {
    taskStore.getMyTasks();
  },

  methods: {

    // getTask(taskId: Number) {
    getTask(taskId) {
      taskStore.getTask(taskId, this.$router);
    },

    // getTaskColor(task: Task, index) {
    getTaskColor(task, index) {
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
