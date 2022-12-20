import VueRouter from "vue-router";
import Vue from "vue";


Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes:[
      // {
      //   path: "/home",
      //   name: "HomePage",
      //   meta: { title: "Home" },
      //   component: ()=> import("@/components/HomePage.vue"),
      // },
      {
          path: "/",
          name: "beranda",
          component: () => import("@/components/NavbarLayout.vue"),
          children: [
                {
                  path: "/",
                  name: "Root",
                  component: () => import("@/views/DashboardIndex.vue"),
                },
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
                  component: () => import("@/views/Team/TambahTeam.vue"),
                  name: "TambahTeam",
                  meta: {title: "TambahTeam"},
                },
                {
                  path: "/tambahmember",
                  component: () => import("@/views/TeamMember/TambahMember.vue"),
                  name: "TambahMember",
                  meta: {title: "TambahMember"},
                },
                {
                  path: "/tambahtournament",
                  component: () => import("@/views/Tournament/TambahTournament.vue"),
                  name: "TournamnetPage",
                  meta: {title: "TambahTournament"},
                },
                // {
                //   path: "/teammember",
                //   component: () => import("@/views/TeamMember/TeamMember.vue"),
                //   name: "TeamMember",
                //   meta: {title: "TeamMember"},
                // },
                // {
                //   path: "/tournament",
                //   component: () => import("@/views/Tournament/TournamentPage.vue"),
                //   name: "Tournament",
                //   meta: {title: "Tournament"},
                // },
                {
                  path: "/transaksitiket",
                  component: () => import("@/views/Ticket/TransaksiTiket.vue"),
                  name: "TransaksiTiket",
                  meta: {title: "TransaksiTiket"},
                },
                {
                  path: "/profile",
                  component: () => import("@/views/ProfilePage.vue"),
                  name: "Profile",
                  meta: {title: "Profile"},
                },
                {
                  path: "/viewteam",
                  component: () => import("@/views/Team/TambahTeam.vue"),
                  name: "ViewTeam",
                  meta: {title: "viewteam"},
                },
          ]
      }
    ]
  });

export default router;