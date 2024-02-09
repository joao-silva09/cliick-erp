import Cookie from "./cookie";
import api from "./api";
import { useUserStore } from "../stores/UserStore";

export default {
  // eslint-disable-next-line  @typescript-eslint/no-unused-vars
  redirectIfAuthenticated(to, from, next) {
    const token = Cookie.getToken();
    let n;
    
    if (token) {
      n = { name: "home" };
    }
    
    next(n);
  },
  
  async redirectIfNotAuthenticated(to, from, next) {
    const token = Cookie.getToken();
    const store = useUserStore();
    let n;
    
    if (!token) {
      n = { name: "login" };
    }
    
    await api.get("me").then((response) => {
      if (!store?.user?.id) {
        store.storeUser(response.data.data);
      }
    }).catch(() => {
      Cookie.deleteToken();
      next({ name: "login" });
    });

    next(n);
  },
};
