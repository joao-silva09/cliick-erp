<template>
  <div class="mb-3.5 w-4/5 bg-yellow-200">
    <h5 v-if="!sentByMe" class="font-bold px-1 text-base">
      {{ $props.username }}
    </h5>
    <div
      class="bg-yellow-300 shadow-xl p-1.5 rounded-md text-base"
      :class="sentByMe ? '' : 'bg-slate-200'"
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

export default {
  name: "Message",
  props: {
    content: String,
    username: String,
    date: String,
    sentByMe: Boolean,
  },
  data() {
    return {};
  },
  methods: {},
};
</script>

<style></style>
