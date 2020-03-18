<template>
    <v-container>
        <v-layout row>
            <v-flex md12>
                <p>Add a Book</p>
                <v-form v-model="valid" ref="form">
                    <v-text-field label="Book Name" v-model="form.name" :rules="nameRules" :counter="30"  color="purple darken-2" > </v-text-field>
                    <v-autocomplete v-model="form.category" :items="getCategories"  label="Category"
                                    required>
                    </v-autocomplete>
                    <v-text-field label="Release year" v-model="form.year" :rules="yearRules" :counter="4"  color="purple darken-2" > </v-text-field>
                    <v-text-field label="Book author" v-model="form.author" :rules="authorRules" :counter="20"  color="purple darken-2" > </v-text-field>
                    <v-textarea label="Book description" v-model="form.description" :rules="urlRules" :counter="200"  color="purple darken-2" > </v-textarea>
                    <v-btn @click="create" :class="{ red: !valid, blue: valid }">Add book </v-btn>
                </v-form>
            </v-flex>
        </v-layout>

        <v-card class="pa-5" v-for="books in getAllOrderedReserved" :key="books.id">
            <v-layout row>
                <v-flex xs12 md12 >
                    <div class="cption grey--text">Book Name</div>
                    <div>{{books.name}}</div>
                    <div v-if="books.is_awaiting_collection">
                        <v-btn rounded color="primary" dark @click="makeBookAvailable(books)">Make book available</v-btn>
                    </div>
                </v-flex>
                <v-layout row v-for="book in books.users" :key="book.id" class="pa-5" :class="`${checkBookStatus(book.pivot.borrow_date,book.pivot.due_date)}`">

                <v-flex xs6 sm2 md2>
                    <div class="cption grey--text">Book Borrow Date</div>
                    <div>{{book.pivot.borrow_date}}</div>
                </v-flex>
                <v-flex xs6 sm2 md2>
                    <div class="cption grey--text">Book Due Date</div>
                    <div>{{book.pivot.due_date}}</div>
                </v-flex>
                <v-flex xs6 sm2 md2>
                    <div class="cption grey--text">Book Reserve Date</div>
                    <div>{{book.pivot.reserve_date}}</div>
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
                     <!-- borrow date is the reserve date and it belongs to those who reserved a book-->
                    <div v-if="checkIfReturnIsThere(book.pivot.return_date)">
                        <v-chip :class="`${checkBookStatus(book.pivot.borrow_date,book.pivot.due_date)}`" @click="takeAction(book,books,book.email,checkActionToTake(book,books))" >{{checkActionToTake(book,books)}}</v-chip>
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
    import axios from "axios";
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
            ...mapGetters(['getAllOrderedReserved','getCategories']),
            selectErrors () {
                const errors = [];
                if (!this.$v.select.$dirty) return errors;
                !this.$v.select.required && errors.push('Item is required');
                return errors
            },

        },
        methods: {
            create() {
                axios
                    .post('/books',this.form)
                    .then(response => {
                        let code = response.status;
                        if(code === 200)
                        {
                            this.informwithnotification("Status" , "Successful , you have successfully added a book");
                            this.$store.dispatch('getAllBooks');
                        }

                    })
                    .catch(error =>
                    {

                    })

            },
            return_book(book,email)
            {
                this.form.book = book;
                this.form.email = email;
                axios
                    .post('/return_book',this.form)
                    .then(response => {
                        let code = response.status;
                        if(code === 200)
                        {
                            this.$store.dispatch('getAllOrderedAndReservedBooks');
                        }
                    })
                    .catch(error =>
                    {
                    })
            },
            //The statuses should be three return, borrowed and collect
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
            checkActionToTake(book,books)
            {
              let reserve = book.pivot.reserve_date;
              let due_date = book.pivot.due_date;
              let status = book.pivot.status;
              let return_date = book.pivot.return_date;
              let borrow_date = book.pivot.borrow_date;
              let is_awaiting_collection = books.is_awaiting_collection;
              let available = books.is_available;
              let collection_status = book.pivot.status;
                if(reserve === null && due_date !== null)
                {
                    console.log("The book should be returned");

                    if(collection_status === 1)
                    {
                        return "Return"
                    }
                    else
                    {
                        // Should have a function to change its status to 1
                        return "Collect Borrowed Book"
                    }

                }
                if(due_date === null  &&  reserve !== null)
                {

                    if(is_awaiting_collection === true)
                    {
                        console.log("The book is awaiting collection " , is_awaiting_collection);
                        return "Collect Reserved Book"
                    }
                    if(is_awaiting_collection === false && available === false)
                    {
                        console.log("The book is still reserved " , is_awaiting_collection);
                        return "Reserved"
                    }
                    if(is_awaiting_collection === false && available === true)
                    {
                        console.log("The book is still reserved " , is_awaiting_collection);
                        return "Did not collect"
                    }
                }
                if(due_date !== null  &&  reserve !== null)
                {
                    if(status === 1 && return_date === null)
                    {
                        return "Return"
                    }
                }

            },
            takeAction(book,books,email,action)
            {
                console.log("This is the action that is meant to be taken " + action);
                if(action === 'Collect Borrowed Book')
                {
                    axios
                        .post('/collect_borrowed',book)
                        .then(response => {
                            let code = response.status;
                            if(code === 200)
                            {
                                this.$store.dispatch('getAllOrderedAndReservedBooks');
                            }
                        })
                        .catch(error =>
                        {
                        })
                }
                if(action === 'Return')
                {
                    this.form.book = books;
                    this.form.email = email;
                    console.log("Returning book ");
                    axios
                        .post('/return_book',this.form)
                        .then(response => {
                            let code = response.status;
                            if(code === 200)
                            {
                                this.$store.dispatch('getAllOrderedAndReservedBooks');
                            }
                        })
                        .catch(error =>
                        {
                        })
                }
                if(action === 'Collect Reserved Book')
                {
                    console.log(action);
                    axios
                        .post('/collect_reserved',book)
                        .then(response => {
                            let code = response.status;
                            if(code === 200)
                            {
                                this.$store.dispatch('getAllOrderedAndReservedBooks');
                            }
                        })
                        .catch(error =>
                        {
                        })
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
            },
            makeBookAvailable(book)
            {
                axios
                    .post('/make_book_available',book)
                    .then(response => {
                        let code = response.status;
                        if(code === 200)
                        {
                            this.$store.dispatch('getAllOrderedAndReservedBooks');
                        }
                    })
                    .catch(error =>
                    {
                    })
            }

        },

        mounted() {
            this.$store.dispatch('getAllOrderedAndReservedBooks');
            this.$store.dispatch('getCategories');
        },

        watch: {

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
