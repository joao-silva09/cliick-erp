import { defineStore } from "pinia";
import api from "../services/api";
import { Customer } from "../types/Customer";
import { useApplicationStore } from "./ApplicationStore";

export const useCustomerStore = defineStore("customer", {
  state: () => ({
    customers: [] as Customer[],
  }),
  actions: {
    storeCustomers(customers) {
      this.customers = customers;
    },
    getCustomers() {
      useApplicationStore().setIsLoading(true);
      api
        .get("customers")
        .then((response) => {
          this.storeCustomers(response.data.data);
        })
        .catch((e) => alert(e))
        .finally(() => useApplicationStore().setIsLoading(false));
    },
  },
});
