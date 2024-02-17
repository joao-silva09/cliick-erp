import { defineStore } from "pinia";
import api from "../services/api";
import { Task } from "../types/Task";
import { useApplicationStore } from "./ApplicationStore";

export const useTaskStore = defineStore("task", {
  state: () => ({
    tasks: [] as Task[],
    task: {} as Task,
  }),
  actions: {
    storeTasks(tasks) {
      this.tasks = tasks;
    },

    storeTask(task) {
      this.task = task;
    },

    storeTaskStatus(status) {
      this.task.status = status;
    },

    storeMessage(messages) {
      this.task.messages = messages;
    },

    getMyTasks() {
      useApplicationStore().setIsLoading(true);
      api
        .get(`tasks`)
        .then((response) => {
          this.storeTasks(response.data.data);
        })
        .catch((e) => alert(e))
        .finally(() => useApplicationStore().setIsLoading(false));
    },

    getCompletedTasks() {
      useApplicationStore().setIsLoading(true);
      api
        .get(`tasks/completed-tasks`)
        .then((response) => {
          this.storeTasks(response.data.data);
        })
        .catch((e) => alert(e))
        .finally(() => useApplicationStore().setIsLoading(false));
    },

    getTask(taskId: Number, router: any) {
      useApplicationStore().setIsLoading(true);
      api
        .get(`tasks/${taskId}`)
        .then((response) => {
          this.storeTask(response.data.data);
        })
        .catch((e) => alert(e))
        .finally(() => {
          router.push({
            name: "task",
            params: {
              task: taskId,
            },
          });
          useApplicationStore().setIsLoading(false);
        });
    },
  },
});
