import { defineStore } from "pinia";
import api from "../services/api";
import { Demand } from "../types/Demand";
import { Task } from "../types/Task";
import { User } from "../types/User";
import { Customer } from "../types/Customer";
import { Team } from "../types/team";

export const useDemandStore = defineStore("demand", {
  state: () => ({
    demands: [] as Demand[],
    customerWithDemands: {} as Customer,
    teamWithDemands: {} as Team,
    tasks: [] as Task[],
    usersToAdd: [] as User[],
    demandIndex: Number,
  }),
  actions: {
    storeDemands(demands: Demand[]) {
      this.demands = demands;
    },

    storeDemandsByCustomer(customer: Customer) {
      this.demands = customer.demands!;
      this.customerWithDemands = customer;
    },

    storeDemandsByTeam(demands, team) {
      this.demands = demands;
      this.teamWithDemands = team;
    },

    getDemands() {
      api.get("demands").then((response) => {
        this.storeDemandsByCustomer(response.data.data);
      });
    },

    storeTasks(tasks) {
      this.demands![Number(this.$state.demandIndex)].tasks =
        tasks;
    },

    storeUsersToAdd(users) {
      this.usersToAdd = users;
    },

    storeDemandIndex(index) {
      this.demandIndex = index;
    },

    clearTeamsAndCustomer() {
      this.customerWithDemands = {} as Customer;
      this.teamWithDemands = {} as Team;
    },
  },
});
