
        <template>

            <v-container fluid>
                <p>These are the total number of books you have borrowed {{getbookscount}}</p>
                <v-data-iterator :items="getBooks"  hide-default-footer>
                    <template v-slot:header>
                        <v-toolbar class="mb-2" color="indigo darken-5" dark flat>
                            <v-toolbar-title>Below are all the books listed in the cytonn library</v-toolbar-title>
                        </v-toolbar>
                    </template>

                    <template v-slot:default="props">
                        <v-row>
                            <v-col v-for="item in props.items"  :key="item.name" cols="12" sm="6" md="4" lg="4">
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
                                            <Moreinfo :book="item"></Moreinfo>
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
    import Moreinfo from "./Moreinfo";
    import notificationmixin from "../mixins/notificationmixin";

    export default {
        name: "displaybooks",
        components: {
                Moreinfo
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
            this.$store.dispatch('getallbooks');
            this.$store.dispatch('getallusersbooks');

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
        watch: {
            '$store.state.ordersuccess' : function () {
                console.log("The ordering was a success");
                this.informwithnotification("Success" , "You have borrowed a book");
                this.$store.dispatch('clearOrderSuccess');
            },
            '$store.state.orderfail' : function () {
                console.log("The ordering was failed");
                this.informwithnotification("Fail" , "You have not managed to borrow a book");
                this.$store.dispatch('clearOrderFail');
            },
            '$store.state.reservesuccess' : function () {
                console.log("The ordering was a success");
                this.informwithnotification("Success" , "You have reserved a book");
                this.$store.dispatch('clearReserveSuccess');
            },
            '$store.state.reservefail' : function () {
                console.log("The ordering was failed");
                this.informwithnotification("Fail" , "You have not managed to reserve a book");
                this.$store.dispatch('clearReserveFail');
            },
            '$store.state.deletesuccess' : function () {
                console.log("The ordering was a success");
                this.informwithnotification("Success" , "You have delete a book");
                this.$store.dispatch('clearDeleteSuccess');
            },
            '$store.state.deletefail' : function () {
                console.log("The ordering was failed");
                this.informwithnotification("Fail" , "You have not managed to deleted a book");
                this.$store.dispatch('clearDeleteFail');
            }
        },
        mixins: [notificationmixin],
    }
</script>

<style scoped>

</style>
