<template>
    <div>

        <v-card class="pa-5" v-for="books in getbookscount[0]" :key="books.id">
            <v-layout row>
                <v-flex xs12 md12 >
                    <div class="cption grey--text">Book Name</div>
                    <div>{{books.name}}</div>
                </v-flex>
                    <v-flex xs6 sm2 md2>
                        <div class="cption grey--text">Book Reserve Date</div>
                        <div>{{books.pivot.borrow_date}}</div>
                    </v-flex>
                    <v-flex xs6 sm2 md2>
                        <div class="cption grey--text">Book Due Date</div>
                        <div>{{books.pivot.due_date}}</div>
                    </v-flex>
                    <v-flex xs6 sm2 md2>
                        <div class="cption grey--text">Book Return Date</div>
                        <div>{{books.pivot.return_date}}</div>
                    </v-flex>
                </v-layout>
        </v-card>
        <v-card class="pa-5" v-for="books in getbookscount[1]" :key="books.id">
            <v-layout row>
                <v-flex xs12 md12 >
                    <div class="cption grey--text">Book Name</div>
                    <div>{{books.name}}</div>
                </v-flex>
                    <v-flex xs6 sm2 md2>
                        <div class="cption grey--text">Book Reserve Date</div>
                        <div>{{books.pivot.borrow_date}}</div>
                    </v-flex>
                    <v-flex xs6 sm2 md2>
                        <div class="cption grey--text">Book Due Date</div>
                        <div>{{books.pivot.due_date}}</div>
                    </v-flex>
                    <v-flex xs6 sm2 md2>
                        <div class="cption grey--text">Book Return Date</div>
                        <div>{{books.pivot.return_date}}</div>
                    </v-flex>
            </v-layout>
        </v-card>
    </div>

</template>

<script>
    import {mapGetters} from "vuex";
    export default {
        name: "MyAccount",
        computed: {
            ...mapGetters(['getbookscount']),
        },
        mounted() {
            this.$store.dispatch('getallusersbooks');

        },
    }
</script>

<style scoped>


</style>
