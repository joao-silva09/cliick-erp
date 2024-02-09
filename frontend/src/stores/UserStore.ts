import { defineStore } from "pinia";
import { User } from "../types/User";

export const useUserStore = defineStore("user", {
  state: () => ({
    user: {} as User,
    users: [] as User[],
    currentRouteName: "",
  }),
  actions: {
    storeUser(user) {
      this.user = user;
    },
    storeUsers(users) {
      this.users = users;
    },
    storeCurrentRouteName(routeName) {
      this.currentRouteName = routeName;
    },
  },
  getters: {},
});
