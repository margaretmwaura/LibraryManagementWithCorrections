
        <template>
            <v-container fluid>
                <v-data-iterator :items="getBooks"  hide-default-footer>
                    <template v-slot:header>
                        <v-toolbar class="mb-2" color="indigo darken-5" dark flat>
                            <v-toolbar-title>Below are all the books listed in the cytonn library</v-toolbar-title>

                        </v-toolbar>
                    </template>

                    <template v-slot:default="proBps">
                        <v-row>
                            <v-col v-for="item in getBooks"  :key="item.name" cols="12" sm="6" md="4" lg="4">
                                <v-card>
                                    <v-card-title class="subheading font-weight-bold">{{ item.name }}</v-card-title>
                                    <v-divider></v-divider>
                                    <v-list dense>
                                        <v-list-item>
                                            <v-list-item-content>Category:</v-list-item-content>
                                            <v-list-item-content class="align-end">{{ item.category }}</v-list-item-content>
                                        </v-list-item>

                                        <v-list-item>
                                            <v-list-item-content>Description:</v-list-item-content>
                                            <v-list-item-content class="align-end">{{ item.description }}</v-list-item-content>
                                        </v-list-item>

                                        <v-list-item>
                                            <v-list-item-content>Release year:</v-list-item-content>
                                            <v-list-item-content class="align-end">{{ item.year }}</v-list-item-content>
                                        </v-list-item>

                                        <v-list-item>
                                            <v-list-item-content>Author:</v-list-item-content>
                                            <v-list-item-content class="align-end">{{ item.author }}</v-list-item-content>
                                        </v-list-item>
                                        <v-list-item>
                                            <MoreInfo :book="item"></MoreInfo>
                                        </v-list-item>

                                    </v-list>
                                </v-card>
                            </v-col>
                        </v-row>
                    </template>

                </v-data-iterator>
            </v-container>
        </template>

<script>
    import {mapGetters} from "vuex";
    import MoreInfo from "./Moreinfo.vue";
    import NotificationMixin from "../mixins/notificationmixin";

    export default {
        name: "display_books",
        components: {
                MoreInfo
            },
        computed: {
            ...mapGetters(['getBooks']),
            numberOfPages () {
                return Math.ceil(this.getBooks.length / this.itemsPerPage)
            },
            filteredKeys () {
                return this.keys.filter(key => key !== `Name`)
            },
        },
        mounted() {
            this.$store.dispatch('getAllBooks');
            this.$store.dispatch('getAUsersBooks');
            this.listenForChanges();
        },
        methods:{
            nextPage () {
                if (this.page + 1 <= this.numberOfPages) this.page += 1
            },
            formerPage () {
                if (this.page - 1 >= 1) this.page -= 1
            },
            updateItemsPerPage (number) {
                this.itemsPerPage = number
            },
            listenForChanges()
            {
                Echo.channel('books').listen('BookUsersUpdated',(e) =>{
                         console.log("An event from laravel " + e);
                         this.$store.state.books = e;

                })
            }
        },
        data()
        {
            return{
                itemsPerPageArray: [3, 6, 9 ,12],
                search: '',
                filter: {},
                sortDesc: false,
                page: 1,
                itemsPerPage: 3,
            }
        },
        mixins: [NotificationMixin],
    }
</script>

<style scoped>

</style>
