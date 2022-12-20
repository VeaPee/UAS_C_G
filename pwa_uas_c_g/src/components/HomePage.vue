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
            
            <v-spacer></v-spacer>
            <div class="white--text"
              >Contact & Our Location</div
            >
            
            
            <iframe 
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3953.0981783199277!2d110.41394041534116!3d-7.77941417934165!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a59f1fb2f2b45%3A0x20986e2fe9c79cdd!2sUniversitas%20Atma%20Jaya%20Yogyakarta%20-%20Kampus%203%20Gedung%20Bonaventura%20Babarsari!5e0!3m2!1sen!2sid!4v1638427863019!5m2!1sen!2sid"
          width="100%"
          height="500"
          frameborder="0"
          style="border: 0; display: block"
          allowfullscreen="true"
          aria-hidden="false"
          tabindex="0"
        ></iframe>
        
            
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
          src: 'https://i.pinimg.com/564x/e1/b2/49/e1b249923026440a60fa45e31d3e357f.jpg',
          heading: ' Onic Esport ',
          subHeading:
            'Onic Esport merupakan salah satu tim yang terkuat di Indonesia yang didirikan oleh Rob Clinton Kardinal. Onic Esport juga telah memenangkan beberapa pertandingan diantaranya MPL. ',
        },
        {
          src: 'https://i.pinimg.com/736x/58/d5/41/58d541293dbc77afed3f0ad8e0dfa656.jpg',
          heading: ' Bigetron Esport',
          subHeading:
            'Bigetron Esport merupakan salah satu tim yang terkuat di Indonesia terutama pada bidang PUBG Mobile. Dimana Bigetron Esport ini telah Meraih Penghargaan yang sangat banyak dari pertandingan PUBG Mobile.',
        },
        {
          src: 'https://i.pinimg.com/474x/08/f8/8d/08f88dd7975881b584cb4055c0125599.jpg',
          heading: ' Evos Esport ',
          subHeading:
            'Evos Esport juga merupakan salah satu tim yang terkuat di Indonesia dalam bidang PUBG Mobile. Evos Esport juga beberapa kali menang dalam pertandingan yang sama dengan Bigetron akan tetapi Bigetron masih tetap yang terkuat.',
        },
        {
          src: 'https://i.pinimg.com/736x/27/a1/80/27a180d92fca54211119b1ca824370ea.jpg',
          heading: ' Aura Esport ',
          subHeading:
            'Aura Esport merupakan salah satu tim Esport yang menciptakan meta-meta yang unik pada permainan Mobile Legend, sehingga dengan menciptakan meta-meta unik hal tersebut membuat para pemain Mobile Legend dari Filipin ingin melawan mereka.'
        },
      ],
    }
  },
  methods: {
    register(){
      this.$router.push({
          name: "RegisterPage",
      });
    },
    login(){
      this.$router.push({
          name: "LoginPage",
      });
    },
    contact(){
      this.$router.push({
        name: "Contact",
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