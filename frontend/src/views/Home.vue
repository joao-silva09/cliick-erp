<template>
  <div class="w-full sm:w-1/2 lg:w-1/3 mx-auto">
    <!-- <div class="flex items-center justify-between mb-8">
      <div class="text-gray-500 font-medium">Lista de tarefas</div>
    </div>

    <form
      @submit.stop.prevent="createTodo"
      class="flex items-center px-4 bg-gray-300 h-15 rounded-sm mb-3"
    >
      <input
        v-model="newTodo"
        type="text"
        placeholder="Digite o nome da sua lista..."
        class="bg-gray-300 placeholder-gray-500 text-gray-700 font-light focus:outline-none block w-full"
      />

      <button class="text-blue-700 text-xs font-semibold focus:outline-none">
        ADICIONAR
      </button>
    </form>

    <div v-if="spinner.get_todos" class="text-center">
      <img src="../assets/img/spinner.svg" alt="" class="w-5 h-5 mr-2" />
    </div> -->

  </div>
</template>

<script>
import api from "../services/api";

export default {
  name: "Home",

  components: {
  },

  data() {
    return {
      newTodo: "",
      todos: [],
      spinner: {
        get_todos: false,
      },
    };
  },

  // created() {
  //   this.getTodos();
  // },

  methods: {
    getTodos() {
      this.spinner.get_todos = true;
      api
        .get("v1/todos")
        .then((response) => {
          this.todos = response.data.data.map((object) => ({
            ...object,
            state: 'show'
          }));
          todoStore.storeTodo(response.data.data);
        })
        .finally(() => {
          this.spinner.get_todos = false;
        });
    },

    createTodo() {
      if (!this.newTodo) {
        return;
      }
      const payload = {
        label: this.newTodo,
      };

      api.post("v1/todos", payload).then((response) => {
        this.todos.unshift(response.data.data);
        this.newTodo = "";
      });
    },

    updateTodo(todo) {
      const payload = {
        label: todo.label,
      };

      api.put(`v1/todos/${todo.id}`, payload);
    },

    destroyTodo(todo) {
      api.delete(`v1/todos/${todo.id}`).then(() => {
        const idx = this.todos.findIndex((object) => object.id === todo.id);
        this.todos.splice(idx, 1);
      });
    },
  },
};
</script>

<style></style>
