<template>
    <nav>
        <v-app-bar >
            <v-app-bar-nav-icon @click="drawer=!drawer">
            </v-app-bar-nav-icon>
            <v-toolbar-title>
              <p id="head">
                  <span>Cytonn</span>
                  <span class="font-weight-light">Libraries</span>
              </p>

            </v-toolbar-title>
            <v-spacer>
            </v-spacer>
            <a href="/logout"> Logout </a>

        </v-app-bar>
        <v-navigation-drawer temporary app class="indigo" v-model="drawer" >

            <v-list>
                <v-list-item router to="/">
                    <v-list-item-icon>
                        <v-icon class="white--text">mdi-view-dashboard</v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title class="white--text">
                            <p id="title_h">Display</p></v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-list>



        </v-navigation-drawer>
    </nav>
</template>

<script>

    export default {
        name: "Navbar",
        data()
        {
            return{
                drawer:false,
            }
        }
    }
</script>

<style scoped>

    #head
    {
        font-size:16px;
        color:black;
    }

    #title_o
    {
        font-size:16px;
        color:white;
    }
    #title_t
    {
        font-size:16px;
        color:white;
    }
    #title_h
    {
        font-size:16px;
        color:white;
    }
</style>
