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
                    <v-chip @click="cancel_borrowing(books)">Cancel Book Borrowing</v-chip>
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
                        <v-chip @click="cancel_reserving(books)">Cancel Book Reserving</v-chip>
                    </v-flex>
            </v-layout>
        </v-card>
    </div>

</template>

<script>
    import {mapGetters} from "vuex";
    import axios from "axios";
    import notificationmixin from "../mixins/notificationmixin";
    import {validationMixin} from "vuelidate";
    export default {
        name: "MyAccount",
        mixins: [validationMixin,notificationmixin],
        computed: {
            ...mapGetters(['getAUsersBooks']),
        },
        mounted() {
            this.$store.dispatch('getAUsersBooks');
        },
        methods : {

            cancel_borrowing(book)
            {
                console.log("Cancelling the book borrowing ");
                axios
                    .post('/cancel_borrow',book)
                    .then(response => {
                        let code = response.status;
                        if(code === 200)
                        {
                            this.informwithnotification("Status" , "Successful , you have cancelled borrowing the book");
                            this.$store.dispatch('getAUsersBooks');
                        }

                    })
                    .catch(error =>
                    {

                    })
            },
            cancel_reserving(book)
            {
                console.log("Cancelling the book reserving ");
                axios
                    .post('/cancel_reserve',book)
                    .then(response => {
                        let code = response.status;
                        if(code === 200)
                        {
                            this.informwithnotification("Status" , "Successful , you have cancelled reserving the book");
                            this.$store.dispatch('getAUsersBooks');
                        }

                    })
                    .catch(error =>
                    {

                    })
            }
        }
    }
</script>

<style scoped>


</style>
