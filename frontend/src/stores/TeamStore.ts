import { defineStore } from "pinia";
import api from "../services/api";
import { useApplicationStore } from "./ApplicationStore";
import { Team } from "../types/team";
import { User } from "../types/User";

export const useTeamStore = defineStore("team", {
  state: () => ({
    teams: [] as Team[],
    usersToAdd: [] as User[],
  }),

  actions: {
    storeTeams(teams) {
      this.teams = teams;
    },

    storeUsersToAdd(users) {
      this.usersToAdd = users;
    },

    getTeams() {
      useApplicationStore().setIsLoading(true);
      api
        .get("teams")
        .then((response) => {
          this.storeTeams(response.data.data);
        })
        .catch((e) => alert(e))
        .finally(() => useApplicationStore().setIsLoading(false));
    },
  },

  getters: {
    getAllTeams(): Team[] {
      return this.teams;
    },
  },
});

export type TeamStore = ReturnType<typeof useTeamStore>;
