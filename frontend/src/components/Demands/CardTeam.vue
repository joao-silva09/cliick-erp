<template>
  <div
    class="text-xl font-bold border border-slate-950 rounded-sm flex flex-col pl-5 pb-5 justify-end h-full w-full hover:bg-slate-600 hover:translate-y-1 hover:transition-all cursor-pointer p-2"
  >
    <!-- {{ this.team }} -->
    {{ this.team.name }}
  </div>
</template>

<script lang="ts">
export default {
  name: "CardTeam",
  props: {
    team: Object,
  },
  data() {
    return {};
  },
  methods: {},
};
</script>

<style></style>
