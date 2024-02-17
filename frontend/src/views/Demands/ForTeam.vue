<template>
  <div>
    <h2 class="text-xl mb-8">Demandas Por Time</h2>

    <div class="grid grid-cols-5 gap-2 h-32">
      <div v-for="team in $pinia.state.value.team.teams" class="flex">
        <CardTeam
          :team="team"
          @click.stop.prevent="getDemandsByTeam(team.id)"
        />
      </div>
    </div>
  </div>
</template>

<script>
import { useTeamStore } from "../../stores/TeamStore";
import { useDemandStore } from "../../stores/DemandStore";
import { useCustomerStore } from "../../stores/CustomerStore";
import CardTeam from "../../components/Demands/CardTeam.vue";
import api from "../../services/api";
import { useApplicationStore } from "../../stores/ApplicationStore";

const demandStore = useDemandStore();
const teamStore = useTeamStore();
export default {
  name: "ForTeam",
  components: {
    CardTeam,
  },

  data() {
    return {
      teams: [],
    };
  },
  mounted() {
    teamStore.getTeams();
    useCustomerStore().getCustomers();
    demandStore.clearTeamsAndCustomer();
    // teams = teamStore.getAllTeams()
  },
  methods: {
    getDemandsByTeam(teamId) {
      useApplicationStore().setIsLoading(true);
      api
        .get(`demands/team/${teamId}`)
        .then((response) => {
          const demandsToAdd = response.data.data.demands.map((demand) => ({
            ...demand,
            open: false,
          }));
          demandStore.storeDemandsByTeam(demandsToAdd, response.data.data);
        })
        .catch((e) => {
          alert(e);
          console.log(e);
        })
        .finally(() => {
          this.$router.push({
            name: "demandsList",
            params: {
              id: teamId,
            },
          });
          useApplicationStore().setIsLoading(false);
        });
    },
  },
};
</script>

<style></style>
