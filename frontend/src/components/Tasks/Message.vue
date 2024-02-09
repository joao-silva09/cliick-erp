<template>
  <div class="mb-3.5 w-4/5" :class="sentByMe ? '' : ''">
    <h5 v-if="!sentByMe" class="font-bold px-1 text-base">
      {{ $props.username }}
    </h5>
    <div
      class="shadow-xl p-1.5 rounded-md text-base"
      :class="getMessageTypeClass()"
    >
      <p>
        {{ $props.content }}
      </p>
      <span class="text-xs flex justify-end">
        {{ $props.date }}
      </span>
    </div>
  </div>
</template>

<script lang="ts">
import { MessageTypeEnum } from "../../types/Enums";

export default {
  name: "Message",
  props: {
    content: String,
    username: String,
    date: String,
    sentByMe: Boolean,
    messageType: {
      type: String,
      required: true,
      // validator: value => Object.values(MessageTypeEnum).includes(value) // Valida se o valor está entre os valores do enum
    },
  },
  data() {
    return { messageType: MessageTypeEnum };
  },
  methods: {
    getMessageTypeClass() {
      if (this.$props.messageType === this.messageType.Default) {
        return "bg-blue-200";
      } else if (this.$props.messageType === this.messageType.RequestApproval) {
        return "bg-yellow-400 py-3";
      } else if (
        this.$props.messageType === this.messageType.Approved ||
        this.$props.messageType === this.messageType.Completed
      ) {
        return "bg-green-400";
      } else {
        return ""; // Pode retornar uma classe padrão ou vazia caso necessário
      }
    },
  },
};
</script>

<style></style>
