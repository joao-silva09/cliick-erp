import { defineStore } from "pinia";

export const useApplicationStore = defineStore("application", {
  state: () => ({
    isLoading: false as Boolean,
  }),

  actions: {
    setIsLoading(isLoading: Boolean) {
      this.isLoading = isLoading;
    },
  },
});
