<template>
    <v-container>
        <v-layout row>
            <v-flex md12>
                <p>Add a Book</p>
                <v-form v-model="valid" ref="form">
                    <v-text-field label="Book Name" v-model="form.name" :rules="nameRules" :counter="30"  color="purple darken-2" > </v-text-field>
                    <v-text-field label="Book category" v-model="form.category" :rules="categoryRules" :counter="20"  color="purple darken-2" > </v-text-field>
                    <v-text-field label="Release year" v-model="form.year" :rules="yearRules" :counter="4"  color="purple darken-2" > </v-text-field>
                    <v-text-field label="Book author" v-model="form.author" :rules="authorRules" :counter="20"  color="purple darken-2" > </v-text-field>
                    <v-textarea label="Book description" v-model="form.description" :rules="urlRules" :counter="200"  color="purple darken-2" > </v-textarea>
                    <v-btn @click="create" :class="{ red: !valid, blue: valid }">Add book </v-btn>
                </v-form>
            </v-flex>
        </v-layout>

        <v-card class="pa-5" v-for="books in getallorderednreserved" :key="books.id">
            <v-layout row>
                <v-flex xs12 md12 >
                    <div class="cption grey--text">Book Name</div>
                    <div>{{books.name}}</div>
                </v-flex>
                <v-layout row v-for="book in books.users" :key="book.id" class="pa-5" :class="`${checkBookStatus(book.pivot.borrow_date,book.pivot.due_date)}`">

                <v-flex xs6 sm2 md2>
                    <div class="cption grey--text">Book Reserve Date</div>
                    <div>{{book.pivot.borrow_date}}</div>
                </v-flex>
                <v-flex xs6 sm2 md2>
                    <div class="cption grey--text">Book Due Date</div>
                    <div>{{book.pivot.due_date}}</div>
                </v-flex>
                <v-flex xs6 sm2 md2>
                    <div class="cption grey--text">Book Borrow Date</div>
                    <div>{{book.pivot.order_date}}</div>
                </v-flex>
                <v-flex xs6 sm2 md2>
                    <div class="cption grey--text">Book Email</div>
                    <div>{{book.email}}</div>
                </v-flex>
                <v-flex xs6 sm2 md2>
                    <div class="cption grey--text">Book Return Date</div>
                    <div>{{book.pivot.return_date}}</div>
                </v-flex>
                <v-flex xs6 sm2 md2>
                    <div>Action</div>
                    <div v-if="checkIfReturnIsThere(book.pivot.return_date)">
                        <v-chip :class="`${checkBookStatus(book.pivot.borrow_date,book.pivot.due_date)}`" @click="returnbook(books,book.email)" >{{checkActionToTake(book.pivot.borrow_date,book.pivot.due_date)}}</v-chip>
                    </div>
                </v-flex>
                </v-layout>
            </v-layout>
        </v-card>
    </v-container>
</template>

<script>
    import { validationMixin } from 'vuelidate'
    import {mapGetters} from "vuex";
    import { required, maxLength, email } from 'vuelidate/lib/validators'
    import notificationmixin from "../mixins/notificationmixin";
    export default {
        mixins: [validationMixin,notificationmixin],
        validations: {
            select: { required },
        },
        name: "BookManagement",
        data()
        {
            return{
                form:{},
                valid: false,
                valid_one: false,
                nameRules: [
                    (v) => !!v || 'A name is required',
                    (v) => v && v.length <= 30 || 'Name must be less than 10 characters'
                ],
                categoryRules: [
                    (v) => !!v || 'A category is required',
                    (v) => v && v.length <= 20 || 'Category must be less than 10 characters'
                ],
                yearRules: [
                    (v) => !!v || 'A year is required',
                    (v) => v && v.length <= 4 || 'Year must be less than 4 characters'
                ],
                authorRules: [
                    (v) => !!v || 'An author is required',
                    (v) => v && v.length <= 20 || 'Author must be less than 10 characters'
                ],
                urlRules: [
                    (v) => !!v || 'A description is required',
                    (v) => v && v.length <= 200 || 'Description must be less than 100 characters'
                ],
            }
        },
        computed: {
            ...mapGetters(['getallPermissions','getallRolesg','getallpermsroles','getallUsersg','getallorderednreserved']),
            selectErrors () {
                const errors = [];
                if (!this.$v.select.$dirty) return errors;
                !this.$v.select.required && errors.push('Item is required');
                return errors
            },

        },
        methods: {
            create() {
                if(this.valid)
                {
                    this.$store.dispatch('addbook',this.form);
                }
                else
                {
                    this.informwithnotification("Fail" , "Ensure you fill all details");
                }

            },
            returnbook(book,email)
            {
                this.form.book = book;
                this.form.email = email
                this.$store.dispatch('returnbook',this.form);
            },
            checkBookStatus(returnDate){

              if(returnDate)
              {
                  return 'borrowed'
              }
              else
              {
                  return 'ordered'
              }
            },
            checkActionToTake(reserve, duedate)
            {

                if(reserve === null && duedate !== null)
                {
                    return "Return"
                }
                else if( duedate === null  &&  reserve !== null)
                {
                    return "awaiting collect"
                }
                else if( reserve !== null && duedate !== null)
                {
                    return "return"
                }
                else
                {
                    return "awaiting collect"
                }
            },
            checkIfReturnIsThere(return_date)
            {
                if(return_date === null)
                {
                    return true
                }
                else
                {
                    return false
                }
            }

        },

        mounted() {
            this.$store.dispatch('getallorderedandreservedbooks');
        },

        watch: {
            '$store.state.addfail' : function () {
                console.log("The adding was a fail");
                this.informwithnotification("Fail" , "You have not added a book");
                this.$store.dispatch('clearAddFail');
            },
            '$store.state.addsuccess' : function () {
                console.log("The adding was successful");
                this.informwithnotification("Sucesss" , "You have  added a book");
                this.$store.dispatch('clearAddSuccess');
            },
        },

    }
</script>

<style scoped>
    .borrowed
    {
        border-left: 4px solid orange;
    }
    .ordered
    {
        border-left: 4px solid tomato;
    }
</style>
