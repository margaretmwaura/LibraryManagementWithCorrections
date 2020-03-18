<template>
    <div>

        <v-card>
            <v-flex xs12 md12 >
                <div>
                    <p>Below are the books you have Borrowed </p>
                </div>
            </v-flex>
        </v-card>

        <v-card class="pa-5" v-for="(books,index) in getAUsersBooks[0]" :key="index">
            <v-layout row>
                <v-flex xs12 md12 >
                    <div class="cption grey--text">Book Name</div>
                    <div>{{books.name}}</div>
                </v-flex>
                    <v-flex xs6 sm2 md2>
                        <div class="cption grey--text">Book Borrow Date</div>
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
                <v-flex xs6 sm2 md2>
                    <v-chip>Cancel Book Borrowing</v-chip>
                </v-flex>
                </v-layout>
        </v-card>

        <v-card>
            <v-flex xs12 md12 >
                <div>
                    <p>Below are the books you have Reserved </p>
                </div>
            </v-flex>
        </v-card>
        <v-card class="pa-5" v-for="(books,index) in getAUsersBooks[1]" :key="index">
            <v-layout row>
                <v-flex xs12 md12 >
                    <div class="cption grey--text">Book Name</div>
                    <div>{{books.name}}</div>
                </v-flex>
                    <v-flex xs6 sm2 md2>
                        <div class="cption grey--text">Book Reserve Date</div>
                        <div>{{books.pivot.reserve_date}}</div>
                    </v-flex>
                    <v-flex xs6 sm2 md2>
                        <div class="cption grey--text">Book Due Date</div>
                        <div>{{books.pivot.due_date}}</div>
                    </v-flex>
                    <v-flex xs6 sm2 md2>
                        <v-chip>Cancel Book Reserving</v-chip>
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
            ...mapGetters(['getAUsersBooks']),
        },
        mounted() {
            this.$store.dispatch('getAUsersBooks');
        },
    }
</script>

<style scoped>


</style>
