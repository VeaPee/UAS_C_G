//import vue router
import { createRouter, createWebHistory } from "vue-router";
//define a routes


const routes = [
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
                path: "/tentangkami",
                component: () => import("@/views/TentangKami.vue"),
                name: "TentangKami",
                meta: { title: "TentangKami" },
              },
              {
                path: "/team",
                component: () => import("@/views/TeamPage.vue"),
                name: "Team",
                meta:{title: "Team"},
              },
              {
                path: "/teammember",
                component: () => import("@/views/TeamMember.vue"),
                name: "TeamMember",
                meta: {title: "TeamMember"},
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
    
  
];

//create router
const router = createRouter({
  history: createWebHistory(),
  routes // config routes
});
export default router;
