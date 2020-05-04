<template>
    <v-container>
        <v-layout row>
            <v-flex md12>
                <p>Add a Book</p>
                <v-form v-model="valid" ref="form">
                    <v-text-field label="Book Name" v-model="form.name" :rules="nameRules" :counter="30"  color="purple darken-2" > </v-text-field>
                    <v-text-field label="Book category" v-model="form.category" :rules="categoryRules" :counter="20"  color="purple darken-2" > </v-text-field>
                    <v-text-field label="Release year" v-model="form.year" :rules="yearRules" color="purple darken-2" :counter="4"> </v-text-field>
                    <v-text-field label="Book author" v-model="form.author" :rules="authorRules" :counter="20"  color="purple darken-2" > </v-text-field>
                    <v-textarea label="Book description" v-model="form.description" :rules="urlRules" :counter="200"  color="purple darken-2" > </v-textarea>
                    <v-btn @click="edit" :class="{ red: !valid, blue: valid }">Edit book </v-btn>
                </v-form>
            </v-flex>
        </v-layout>

        </v-container>
</template>

<script>

    import {validationMixin} from "vuelidate";
    import notificationmixin from "../../mixins/notificationmixin";
    import {required} from "vuelidate/lib/validators";
    import axios from "axios";

    export default {
        name: "Edit_book",
        mixins: [validationMixin,notificationmixin],
        validations: {
            select: { required },
        },
        data() {
            return {
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
        methods: {
            edit() {
                if(this.valid)
                {
                    axios
                        .post('/books_edit',this.form)
                        .then(response => {
                            const code = response.status;
                            if(code === 200)
                            {
                                this.informwithnotification("Status" , "Successful , you have successfully ");
                                this.$store.dispatch('getAllBooks');
                            }
                            else
                            {

                            }
                        })
                        .catch(error =>
                        {

                        })

                }
                else
                {
                    this.informwithnotification("Error" , "Please enter all the details");
                }

            }
        },

        created() {
            console.log("Edit has been called");
            this.book = this.$route.params.book;
            this.form.name = this.$route.params.book.name;
            this.form.category = this.$route.params.book.category;
            this.form.year = this.$route.params.book.year;
            this.form.author = this.$route.params.book.author;
            this.form.description = this.$route.params.book.description;
            this.form.id = this.$route.params.book.id;

        },
    }
</script>

<style scoped>

</style>

