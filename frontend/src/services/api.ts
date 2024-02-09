import axios, { AxiosInstance } from "axios";
import cookie from "./cookie";

const api: AxiosInstance = axios.create({
  baseURL: "https://erp-api.agenciacliick.com.br/default.php/api/",
  headers: {
    "Content-Type": "application/json",
    Accept: "application/json",
  },
});

api.interceptors.request.use(function (config) {
  const token = cookie.getToken();

  if (token) {
    config.headers.setAuthorization(token);
  }

  return config;
});

export default api;
