<template>
  
    <v-carousel
      height="100vh"
      dark
      cycle
      show-arrows-on-hover
      draggable="true"
      hide-delimiter-background
    >
      <v-carousel-item
        v-for="(carousel, carindex) in carouselsData"
        :key="carindex"
        :src="carousel.src"
        class="gradient-fill"
      >
        <v-container fill-height>
          <div style="max-width: 900px">
            
            <div class="text-md-h2 mb-3 text-sm-h3 text-h5 font-weight-black white--text">
              {{ carousel.heading.toUpperCase() }}
            </div>
            
            <p class="mb-5 white--text">{{ carousel.subHeading }}</p>
            
            <v-btn @click="login" :x-large="$vuetify.breakpoint.smAndUp" class="my-3 primary"
              >Login</v-btn
            >
            <span class="mx-2 my-4"></span>
            <v-btn @click="register" :x-large="$vuetify.breakpoint.smAndUp" class="my-3 orange white--text"
              >Register</v-btn
            >
            
=
        
            
          </div>
        </v-container>
      </v-carousel-item>
      
    </v-carousel>
    
 
</template>


<script>
export default {
  data() {
    return {
      carouselsData: [
        {
          src: 'https://www.linknet.id//files/photos/shares/images/article/industri-esport-perhatikan-kecepatan-internet.png',
          heading: ' E-Sporstation ',
          subHeading:
            'Komunitas E-Sport Indonesia untuk membuat Team, Tournament dan membeli Ticket Nonton',
        },
        {
          src: 'https://akcdn.detik.net.id/visual/2020/07/20/esport-1_169.jpeg?w=650',
          heading: ' E-Sporstation ',
          subHeading:
            'Komunitas E-Sport Indonesia untuk membuat Team, Tournament dan membeli Ticket Nonton',
        },
        {
          src: 'https://asset-a.grid.id/crop/0x0:0x0/700x0/photo/2022/10/26/dota2_ti11_singapore_suntec_main-20221026050323.jpg',
          heading: ' E-Sporstation ',
          subHeading:
            'Komunitas E-Sport Indonesia untuk membuat Team, Tournament dan membeli Ticket Nonton',
        },
        {
          src: 'https://statik.tempo.co/data/2019/01/28/id_815298/815298_720.jpg',
          heading: ' E-Sporstation ',
          subHeading:
            'Komunitas E-Sport Indonesia untuk membuat Team, Tournament dan membeli Ticket Nonton'
        },
      ],
    }
  },
  methods: {
    register(){
      this.$router.push({
          name: "register",
      });
    },
    login(){
      this.$router.push({
          name: "login",
      });
    },
    contact(){
      this.$router.push({
        name: "aboutus",
      })
    }
  }
  }
</script>

<style>
.gradient-fill .v-responsive__content {
  background: rgb(0, 0, 0);
  background: linear-gradient(
    to right,
    rgba(3, 12, 41, 0.75),
    rgba(5, 11, 31, 0.65)
  );
}
.carousel-item img {
        height:100vh!important ;
    }
</style>