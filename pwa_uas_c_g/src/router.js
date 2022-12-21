import VueRouter from "vue-router";
import Vue from "vue";


Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes:[
        {
          path: "/",
          name: "Home",
          component: () => import("@/components/HomePage.vue"),
          meta: {title: "Home"},
        },
        {
          path: "/register",
          name: "register",
          component: () => import("@/views/RegisterPage.vue"),
          meta: {title: "Register"},
        },
        {
          path: "/login",
          name: "login",
          component: () => import("@/views/LoginPage.vue"),
          meta: {title: "Login"},
        },
        {
          path: "/",
          name: "beranda",
          component: () => import("@/components/NavbarLayout.vue"),
          children: [
                {
                  path: "/Menu",
                  name: "Menu",
                  component: () => import("@/views/MainMenu.vue"),
                  meta: {title: "Menu"},
                },
                {
                  path: "/aboutus",
                  component: () => import("@/views/AboutUs.vue"),
                  name: "AboutUs",
                  meta: { title: "About" },
                },
                {
                  path: "/tambahteam",
                  component: () => import("@/views/Team/TambahTeam.vue"),
                  name: "TambahTeam",
                  meta: {title: "Team"},
                },
                {
                  path: "/tambahteammember",
                  component: () => import("@/views/TeamMember/TambahMember.vue"),
                  name: "TambahMember",
                  meta: {title: "Member Team"},
                },
                {
                  path: "/tambahtournament",
                  component: () => import("@/views/Tournament/TambahTournament.vue"),
                  name: "TournamentPage",
                  meta: {title: "Tournament"},
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
          ],
        },
    
      ]
    });

  router.beforeEach((to, from, next) => {
    if(to.name != "login" && localStorage.getItem("token") == null && to.name!="register" && to.name != "Home"){
        next('/')
        document.to.meta.title = "Menu"
    }
    
    document.title = to.meta.title;
    next();
  });

export default router;