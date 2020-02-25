<template>
    <div class="text-center">

        <v-dialog v-model="dialog" width="500">
            <template v-slot:activator="{ on }">
                <v-btn class="ma-2" outlined color="indigo" dark v-on="on">Read More</v-btn>
            </template>
            <v-card>
                <v-card-title primary-title>
                    <p>{{book.name}}</p>
                </v-card-title>
                <v-card-text>
                    <p>{{book.description}}</p>
                </v-card-text>
                <v-card-text>
                    <p>Author : {{book.author}}</p>
                </v-card-text>
                <v-card-text>
                    <p>Category :  {{book.category}}</p>
                </v-card-text>
                <v-card-text>
                    <div v-if="checkRemainingBooks()">
                        <p> You have borrowed a total of {{ numberOfBorrowedBooks }} , the remaining borrow count is {{borrow_count}}</p>
                    </div>
                    <div v-else>
                        <p>You cannot borrow more books you have exceeded 3 books</p>
                    </div>
                </v-card-text>
                <v-divider></v-divider>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn v-on:click="deleting(book.id)"  v-if="$can_delete('Delete',book.is_available)">Delete</v-btn>
                    <v-spacer></v-spacer>
                    <v-btn v-on:click="editing(book)"  v-if="$can_edit('Edit',book.is_available)">Edit </v-btn>
                    <v-spacer></v-spacer>

                    <div v-if="checkRemainingBooks()">
                        <v-btn  v-on:click="orderBook(book)" v-if="$can_borrow('Borrow',book.is_available)">Borrow </v-btn>
                        <v-spacer></v-spacer>
                    </div>
                    <div v-if="reservable()">
                        <v-btn v-on:click="reserveBook(book)" v-if="$can_reserve('Reserve',book.is_reservable)">Reserve </v-btn>
                    </div>

                    <v-spacer></v-spacer>
                    <v-divider></v-divider>
                    <v-btn color="primary" text @click="togglingPermissions">
                        Close
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>
<script>
    import {mapGetters} from "vuex";
    import axios from "axios";
    export default {
        name: "MoreInfo",
        data()
        {
            return{
                dialog:false,
                formAssign:{},
                status : true
            }
        },
        computed: {
            ...mapGetters(['getAUsersBooks','getBooks']),
            borrow_count()
            {
                let remain = 3 - this.getAUsersBooks[0].length;
                return remain;
            },
            numberOfBorrowedBooks()
            {
                return this.getAUsersBooks[0].length;
            }

        },
        props: {
            book: Array,
        },
        methods: {
            togglingPermissions: function(user)
            {
                this.dialog = false;
            },
            deleting(id)
            {
                axios
                    .delete('/books/' + id,{
                    })
                    .then(response => {
                        const code = response.status;
                        if(code === 200)
                        {
                            this.informwithnotification("Deleting" , "You have deleted a book");
                        }
                        else
                        {

                        }
                    })
                    .catch(error =>
                    {

                    })
                this.dialog = false;
            },
            editing(book)
            {
                console.log("We want to edit the blog");
                this.$router.push({
                    name: 'Edit',
                    params: {
                        book: book,
                    }
                });
                this.dialog = false;
            },
            orderBook(book)
            {
                axios
                    .post('/order_book',book)
                    .then(response => {
                        let code = response.status;
                        if(code === 200)
                        {
                            //Updating the records of the books and users
                            this.$store.dispatch('getAllBooks');
                            this.$store.dispatch('getAUsersBooks');
                        }
                    })
                    .catch(error =>
                    {

                    });
                this.dialog = false;
            },
            reserveBook(book)
            {
                axios
                    .post('/reserve_book',book)
                    .then(response => {
                        var code = response.status;
                        if(code === 200)
                        {
                            //Updating the records of the books and users
                            this.$store.dispatch('getAllBooks');
                            this.$store.dispatch('getAUsersBooks');
                        }
                        else
                        {

                        }
                    })
                    .catch(error =>
                    {

                    })
            },
            show_reserve(id)
            {
                if(id === 2)
                {
                    return true;
                }
                else
                {
                    return false
                }
            },
            show_borrow(id)
            {
                if(id === 1)
                {
                    return true;
                }
                else
                {
                    return false
                }
            },
            checkRemainingBooks()
            {
                if(this.numberOfBorrowedBooks < 3)
                {
                    console.log("The condition sis true");
                    return true
                }
                if(this.numberOfBorrowedBooks >= 3)
                {
                    console.log("The condition sis true");
                    return false;
                }
                else
                {
                    console.log("The condition sis false");
                    return false
                }
                },
            reservable()
            {
                let $userBooks = this.getAUsersBooks[0];
                console.log("These are the books I have borrowed " + $userBooks);
                if($userBooks.some(book => book.name === this.book.name)){
                    console.log("Book was found in the array");
                    return false;
                } else{
                    console.log("No book was found in the array");
                    return true;
                }
            }

        },
        mounted() {
            this.$store.dispatch('getAUsersBooks');
        },
    }
</script>

<style scoped lang="scss">

    p{
        font-size:16px;
        line-height: 1.5em;
        text-align: center;
        color:black;
    }
</style>

