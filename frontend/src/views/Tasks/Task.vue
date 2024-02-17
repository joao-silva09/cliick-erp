<template>
  <BackIcon @click="goBack()" class="w-5 h-5 text-blue-600 cursor-pointer" />
  <div class="grid grid-cols-2 gap-2 pt-5">
    <div class="w-full flex flex-col gap-5">
      <div class="w-full border border-blue-700 p-3 rounded shadow-xl">
        <div class="flex justify-between items-center">
          <h2 class="text-xl">
            {{ $pinia.state.value.task.task.title }}
          </h2>

          <!-- TODO: Criar modal para solicitar aprovação no caso de funcionário -->
          <!-- <div>
            <CheckCircleIcon
              class="w-8 h-8 text-yellow-500 cursor-pointer hover:text-yellow-800 hover:scale-110"
              @click="openRequestApprovalTaskModal"
            />
          </div> -->
          <div>
            <CheckCircleIcon
              class="w-8 h-8 text-green-500 cursor-pointer hover:text-green-800 hover:scale-110"
              @click="openCompleteTaskModal"
            />
          </div>
        </div>
        <p class="text-sm">
          <b>Descrição: </b>{{ $pinia.state.value.task.task.description }}
        </p>
        <h5><b>Status: </b>{{ $pinia.state.value.task.task.status }}</h5>
        <p>
          <b>Cliente: </b
          >{{ $pinia.state.value.task.task.demand.customer.name }}
        </p>
        <p>
          <b>Prazo: </b>
          {{
            new Date($pinia.state.value.task.task.deadline).toLocaleDateString()
          }}
        </p>
        <p>
          <b>Criado por: </b>
          {{ $pinia.state.value.task.task.created_by }}
        </p>
      </div>

      <!-- <RequestApprovalTaskModal ref="requestApprovalTaskModal" /> -->
      <CompleteTaskModal ref="completeTaskModal" />

      <div class="grid grid-cols-2 gap-5">
        <div class="w-full border border-blue-700 p-3 rounded shadow-xl">
          <h2 class="font-bold">Times Envolvidos:</h2>
          <div
            v-for="team in $pinia.state.value.task.task.demand.teams"
            :key="team.id"
          >
            {{ team.name }}
          </div>
        </div>

        <div class="w-full border border-blue-700 p-3 rounded shadow-xl">
          <h2 class="font-bold">Atribuído a:</h2>
          <div
            v-for="user in $pinia.state.value.task.task.users"
            :key="user.id"
          >
            {{ user.first_name + " " + user.last_name }}
          </div>
        </div>
      </div>
    </div>

    <!-- h-screen rounded-sm p-4 flex flex-1 flex-col justify-end overflow-y-auto -->
    <div>
      <div
        class="px-3 messages h-[68vh] overflow-y-auto bg-sky-100 rounded p-2"
        ref="messageContainer"
      >
        <div
          v-for="message in $pinia.state.value.task.task.messages"
          :class="message.username === userName ? 'flex justify-end' : ''"
          :key="message.id"
        >
          <Message
            :username="message.username"
            :content="message.message"
            :date="new Date(message.created_at).toLocaleString()"
            :sent-by-me="message.username === userName"
            :message-type="message.message_type"
          />
          <!-- <RequestApprovalMessage
            v-else-if="message.message_type === 'request_approval'"
            :username="message.username"
            :content="message.message"
            :date="new Date(message.created_at).toLocaleString()"
            :sent-by-me="message.username === userName"
          /> -->
        </div>
      </div>
      <!-- disabled="{{ $pinia.state.value.task.task.status === 'Concluído' }}" -->
      <input
        v-model="contentMessage"
        type="text"
        placeholder="Digite sua mensagem..."
        class="border mt-1 border-gray-400 shadow-xl w-full p-2 rounded focus:outline-none"
        @keyup.enter="sendMessage()"
      />
    </div>
  </div>
</template>

<script>
import { useTaskStore } from "../../stores/TaskStore";
import { useUserStore } from "../../stores/UserStore";
import Message from "../../components/Tasks/Message.vue";
import RequestApprovalMessage from "../../components/Tasks/Message.vue";
// import RequestApprovalTaskModal from "../../components/Tasks/RequestApprovalTaskModal.vue";
import CompleteTaskModal from "../../components/Tasks/CompleteTaskModal.vue";
import api from "../../services/api";
import {
  CheckCircleIcon,
  ArrowLeftIcon as BackIcon,
} from "@heroicons/vue/24/outline";
import { useApplicationStore } from "../../stores/ApplicationStore";

const userStore = useUserStore();
const taskStore = useTaskStore();
export default {
  name: "task",

  components: {
    Message,
    // RequestApprovalTaskModal,
    CheckCircleIcon,
    RequestApprovalMessage,
    CompleteTaskModal,
    BackIcon,
  },

  data() {
    return {
      isCompleteTaskModalOpen: false,
      contentMessage: "",
      userName: userStore.user.first_name + " " + userStore.user.last_name,
    };
  },

  created() {
    this.messagesList = taskStore.task.messages;
  },

  mounted() {
    this.scrollToBottom();
  },

  methods: {
    goBack() {
      this.$router.go(-1);
    },

    openRequestApprovalTaskModal() {
      this.$refs.requestApprovalTaskModal.openModal();
    },

    openCompleteTaskModal() {
      this.$refs.completeTaskModal.openModal();
    },

    sendMessage() {
      useApplicationStore().setIsLoading(true);

      const payload = {
        message: this.contentMessage,
        task_id: taskStore.task.id,
      };

      api
        .post("messages", payload)
        .then((response) => {
          const currentMessages = taskStore.task.messages;
          currentMessages?.push(response.data.data);
          taskStore.storeMessage(currentMessages);
          // this.messagesList.push(response.data.data);
        })
        .catch((e) => alert(e))
        .finally(() => {
          this.scrollToBottom();
          useApplicationStore().setIsLoading(false);
        });

      this.contentMessage = "";
    },

    scrollToBottom() {
      // Acesse o elemento com a ref e role para o final
      const container = this.$refs.messageContainer;
      container.scrollTop = container.scrollHeight;
    },
  },
};
</script>

<style>
.messages::-webkit-scrollbar {
  width: 10px;
}
.messages::-webkit-scrollbar-track {
  background-attachment: #ddd;
}
.messages::-webkit-scrollbar-thumb {
  background-color: #ddd;
}
</style>
