<template>
    <v-main>
        <h1 class="text font-weight-medium mb-5 text-center">List Tournament</h1>

        <v-item-group>
            <v-container>
                <v-row>
                    <v-col v-for="n in 3" :key="n" cols="12" md="4">
                        <v-card :loading="loading" class="mx-auto my-12" max-width="374">
                            <v-img
                            height="250"
                            src="https://pict.sindonews.net/dyn/850/pena/news/2022/06/07/11/790973/piala-presiden-2022-segera-digelar-ini-jadwal-dari-fase-grup-hingga-final-ath.jpg"
                            ></v-img>

                            <v-card-title class="d-flex justify-content-center"><strong>Tournament </strong></v-card-title>

                            <v-card-text>
                                <div class="my-4 text-subtitle-1">
                                    Tournament Nasional untuk game PUBG
                                    Daftarkan diri anda sekarang juga!!.
                                </div>
                            </v-card-text>

                            <v-divider class="mx-4"></v-divider>
                            <v-card-actions>
                                <v-btn color="deep-purple lighten-2" text @click="reserve">
                                Choose
                                </v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-col>
                </v-row>
            </v-container>
        </v-item-group>
    </v-main>
</template>
<style>
.text {
    font-family: "Franklin Gothic Medium", "Arial Narrow", Arial, sans-serif;
}
</style>
<script>
export default {
    data: () => ({
        loading: false,
        selection: 1,
    }),
};
</script>