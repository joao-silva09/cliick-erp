import Guard from "../services/middleware";

export const routes = [
  {
    path: "/login",
    component: () =>
      import(/* webpackChunkName: "home" */ "../layouts/Auth.vue"),
    beforeEnter: Guard.redirectIfAuthenticated,
    children: [
      {
        path: "",
        name: "login",
        component: () =>
          import(/* webpackChunkName: "login" */ "../views/Login.vue"),
      },
    ],
  },
  {
    path: "/",
    component: () =>
      import(/* webpackChunkName: "home" */ "../layouts/Default.vue"),
    beforeEnter: Guard.redirectIfNotAuthenticated,
    children: [
      {
        path: "",
        name: "home",
        component: () =>
          import(/* webpackChunkName: "home" */ "../views/Home.vue"),
      },
      {
        path: "customers",
        name: "customers",
        component: () =>
          import(/* webpackChunkName: "customers" */ "../views/Customers.vue"),
      },
      {
        path: "financial",
        name: "financial",
        component: () =>
          import(/* webpackChunkName: "financial" */ "../views/Financial.vue"),
      },
      {
        path: "teams",
        name: "teams",
        component: () =>
          import(/* webpackChunkName: "teams" */ "../views/Teams.vue"),
      },
      {
        path: "demands",
        name: "demands",
        children: [
          {
            path: "",
            name: "demandsGeral",
            component: () =>
              import(
                /* webpackChunkName: "forTeam" */ "../views/Demands/index.vue"
              ),
          },
          {
            path: "overview",
            name: "overview",
            component: () =>
              import(
                /* webpackChunkName: "Overview" */ "../views/Demands/Overview.vue"
              ),
          },
          {
            path: "my-tasks",
            name: "myTasks",
            component: () =>
              import(
                /* webpackChunkName: "MyTasks" */ "../views/Demands/MyTasks.vue"
              ),
          },
          {
            path: "completed",
            name: "completedTasks",
            component: () =>
              import(
                /* webpackChunkName: "Completed" */ "../views/Demands/Completed.vue"
              ),
          },
          {
            path: "for-team",
            name: "demandsForTeam",
            component: () =>
              import(
                /* webpackChunkName: "forTeam" */ "../views/Demands/ForTeam.vue"
              ),
          },
          {
            path: ":id",
            name: "demandsList",
            component: () =>
              import(
                /* webpackChunkName: "forTeam" */ "../views/Demands/DemandsList.vue"
              ),
          },
          {
            path: "for-customer",
            name: "demandsForCustomer",
            component: () =>
              import(
                /* webpackChunkName: "forTeam" */ "../views/Demands/ForCustomer.vue"
              ),
          },
          // {
          //   path: "for-customer/:customer",
          //   name: "demandsForCustomer",
          //   component: () =>
          //     import(
          //       /* webpackChunkName: "forTeam" */ "../views/Demands/ForCustomer.vue"
          //     ),
          // },
        ],
      },
      {
        path: "task",
        name: "tasks",
        children: [
          {
            path: ":task",
            name: "task",
            component: () =>
              import(
                /* webpackChunkName: "forTeam" */ "../views/Tasks/Task.vue"
              ),
          },
        ],
      },
    ],
  },
  {
    path: "/:pathMatch(.*)",
    component: () =>
      import(/* webpackChunkName: "error" */ "../views/Error404.vue"),
  },
];
