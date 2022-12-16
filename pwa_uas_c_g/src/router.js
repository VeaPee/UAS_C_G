//import vue router
import { createRouter, createWebHistory } from "vue-router";
//define a routes

import Vue from "vue";
import VueRouter from "vue-router";

Vue.use(VueRouter);

function importComponent(path) {
  return () => import(`./components/${path}.vue`);
}

function importLayout(path) {
  return () => import(`./view/${path}.vue`);
}
const routes = [
    {
        path: "/",
        name: "beranda",
        component: () => import("@/components/DashboardLayout.vue"),
        children: [
            {
                path: "/register",
                name: "register",
                component: () => import("@/views/RegisterPage.vue"),
              },
              {
                path: "/login",
                name: "login",
                component: () => import("@/views/LoginPage.vue"),
              },
              {
                path: "/tentangkami",
                component: importComponent("TentangKami"),
                name: "TentangKami",
                meta: { title: "TentangKami" },
              },
              {
                path: "/team",
                component: importComponent("team"),
                name: "Team",
                meta:{title: "Team"},
              },
              {
                path: "/teamember",
                component: importComponent("teammember"),
                name: "TeamMember",
                meta: {title: "TeamMember"},
              },
              {
                path: "/tournament",
                component: importComponent("tournament"),
                name: "Tournament",
                meta: {title: "Tournament"},
              },
              {
                path: "/transaksitiket",
                component: importComponent("transaksitiket"),
                name: "TransaksiTiket",
                meta: {title: "TransaksiTiket"},
              },
              {
                path: "/profile",
                component: importComponent("profile"),
                name: "Profile",
                meta: {title: "Profile"},
              },
        ]
    }
    
  
];

//create router
const router = createRouter({
  history: createWebHistory(),
  routes // config routes
});
export default router;
