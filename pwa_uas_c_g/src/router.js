import VueRouter from "vue-router";
import Vue from "vue";


Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes:[
      {
          path: "/",
          name: "beranda",
          component: () => import("@/components/NavbarLayout.vue"),
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
                  path: "/aboutus",
                  component: () => import("@/views/AboutUs.vue"),
                  name: "TentangKami",
                  meta: { title: "TentangKami" },
                },
                {
                  path: "/tambahteam",
                  component: () => import("@/views/TambahTeam.vue"),
                  name: "TambahTeam",
                  meta: {title: "TambahTeam"},
                },
                {
                  path: "/tournament",
                  component: () => import("@/views/TournamentPage.vue"),
                  name: "Tournament",
                  meta: {title: "Tournament"},
                },
                {
                  path: "/transaksitiket",
                  component: () => import("@/views/TransaksiTiket.vue"),
                  name: "TransaksiTiket",
                  meta: {title: "TransaksiTiket"},
                },
                {
                  path: "/profile",
                  component: () => import("@/views/ProfilePage.vue"),
                  name: "Profile",
                  meta: {title: "Profile"},
                },
          ]
      }
    ]
  });
export default router;