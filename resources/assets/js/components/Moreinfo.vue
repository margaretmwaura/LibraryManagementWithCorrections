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
<!--                <v-card-text>-->
<!--                    <div v-if="checkRemainingBooks(getbookscount)">-->
<!--                        <p> You have borrowed a total of {{getbookscount}} , the remaining borrow count is {{borrowcount(getbookscount)}}</p>-->
<!--                    </div>-->
<!--                    <div v-else>-->
<!--                        <p>You cannot borrow more books you have exceeded 3 books</p>-->
<!--                    </div>-->
<!--                </v-card-text>-->
                <v-divider></v-divider>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn v-on:click="deleting(book.id)"  v-if="$candelete('Delete',book.status_id)">Delete</v-btn>
                    <v-spacer></v-spacer>
                    <v-btn v-on:click="editting(book)"  v-if="$canedit('Edit',book.status_id)">Edit </v-btn>
                    <v-spacer></v-spacer>
<!--                    <div v-if="checkRemainingBooks(getbookscount)">-->
                    <div>
                        <v-btn  v-on:click="orderBook(book)" v-if="$canborrow('Borrow',book.status_id)">Borrow </v-btn>
                        <v-spacer></v-spacer>
                    </div>
                    <v-btn v-on:click="reserveBook(book)" v-if="$canreserve('Reserve',book.status_id)">Reserve </v-btn>
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

    export default {
        name: "Popup",
        data()
        {
            return{
                dialog:false,
                formAssign:{}
            }
        },
        computed: {
            ...mapGetters(['getallRolesg','getbookscount']),
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
                console.log("Id of the deleting " + id);
                this.$store.dispatch('deleteABook',id);
                this.dialog = false;
            },
            editting(book)
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
                this.$store.dispatch('orderBook',book);
                this.dialog = false;
            },
            reserveBook(book)
            {
                console.log("A book has been reserved");
                this.$store.dispatch('reserveBook',book);
                this.dialog = false;
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
            checkRemainingBooks(count)
            {
                if(count < 3)
                {
                    console.log("The condition sis true");
                    return true
                }
                if(count >= 3)
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
            borrowcount(count)
            {
                let remain = 3 - count;
                return remain;
            }
        }
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

