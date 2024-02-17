<template>
  <div style="height: 300px">
    <!-- <LoginMenu /> -->

    <div
      v-if="response.message"
      :class="`rounded-sm bg-${response.color}-100 p-4 mb-4`"
    >
      <h3 :class="`text-sm leading-5 font-medium text-${response.color}-800`">
        <!-- {{ response.message }} -->
      </h3>
    </div>

    <div class="grid gap-2">
      <input
        v-model="email"
        type="text"
        placeholder="Digite seu e-mail"
        class="bg-gray-900 placeholder-gray-700 text-gray-500 font-light border border-gray-900"
      />

      <input
        v-model="password"
        type="password"
        placeholder="Digite sua senha"
        class="bg-gray-900 placeholder-gray-700 text-gray-500 font-light border border-gray-900"
      />

      <button
        @click.stop.prevent="login()"
        :disabled="spinner.login"
        class="flex items-center justify-center bg-blue-800 text-blue-200 font-medium text-sm focus:outline-none rounded-sm py-3 px-4"
      >
        <img
          v-if="spinner.login"
          src="../assets/img/spinner.svg"
          alt=""
          class="w-5 h-5 mr-2"
        />

        ENTRAR
      </button>
    </div>
  </div>
</template>

<script>
import api from '../services/api';
import cookie from '../services/cookie';
import { useUserStore } from '../stores/UserStore';

const storeUser = useUserStore();

export default {
  name: "Login",

  components: {},

  data() {
    return {
      email: "",
      password: "",
      response: {
        color: "",
        message: "",
      },
      spinner: {
        login: false,
      },
    };
  },

  methods: {
    login() {
      const payload = {
        email: this.email,
        password: this.password,
      };

      this.resetResponse();

      this.spinner.login = true;

      api
        .post("login", payload)
        .then((response) => {
          const token = `${response.data.token_type} ${response.data.access_token}`;
          cookie.setToken(token);

          storeUser.storeUser(response.data.data);

          this.$router.push({ name: "home" });
        })
        .catch((e) => {
          this.spinner.login = false;
          const errorCode = e?.response?.data?.error || "ServerError";
          this.response.color = "red";
          // this.response.message = message[errorCode];
        });
    },

    resetResponse() {
      this.response.color = "";
      this.response.message = "";
    },
  },
};
</script>

<style></style>
