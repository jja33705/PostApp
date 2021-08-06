<template>
  <v-app id="inspire">
    <v-navigation-drawer
      v-model="drawer"
      app
    >
        <v-list dense>
          <v-list-item
            :to="{name: 'index'}"
          >
            <v-list-item-icon>
              <v-icon>mdi-view-dashboard</v-icon>
            </v-list-item-icon>
  
            <v-list-item-content>
              <v-list-item-title>Home</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list>
    </v-navigation-drawer>

    <v-app-bar app>
      <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>

      <v-toolbar-title>VuePostApp</v-toolbar-title>
      
      <v-spacer></v-spacer>
     
      <v-menu
        bottom
        min-width="200px"
        rounded
        offset-y
      >
        <template v-slot:activator="{ on }">
          <v-btn
            icon
            x-large
            v-on="on"
          >
            <v-avatar
              color="brown"
              size="48"
            >
              <span class="white--text text-h5">{{ initials }}</span>
            </v-avatar>
          </v-btn>
        </template>
        <v-card>
          <v-list-item-content class="justify-center">
            <div class="mx-auto text-center">
              <v-avatar
                color="brown"
              >
                <span class="white--text text-h5">{{ initials }}</span>
              </v-avatar>
              <h3>{{ name }}</h3>
              <p class="text-caption mt-1">
                {{ email }}
              </p>
              <v-divider class="my-3"></v-divider>
              <template v-if="isAuthenticated">
                <v-btn
                    depressed
                    rounded
                    text
                >
                    Edit Account
                </v-btn>
                <v-divider class="my-3"></v-divider>
                <v-btn
                    depressed
                    rounded
                    text
                    @click="onClickLogout"
                >
                    Disconnect
                </v-btn>
              </template>
              <template v-else>
                <v-btn
                    depressed
                    rounded
                    text
                    :to="{name: 'login'}"
                >
                    login
                </v-btn>
                <v-divider class="my-3"></v-divider>
                <v-btn
                    depressed
                    rounded
                    text
                    :to="{name: 'register'}"
                >
                    register
                </v-btn>
              </template>


            </div>
          </v-list-item-content>
        </v-card>
      </v-menu>
    </v-app-bar>

    <v-main app>
      <router-view></router-view>
    </v-main>
    <v-footer
      dark
      padless
      app
    >
      <v-card
        class="flex"
        flat
        tile
      >
        <v-card-title class="teal">
          <strong class="subheading">Get connected with us on social networks!</strong>
  
          <v-spacer></v-spacer>
  
          <v-btn
            v-for="icon in icons"
            :key="icon"
            class="mx-4"
            dark
            icon
          >
            <v-icon size="24px">
              {{ icon }}
            </v-icon>
          </v-btn>
        </v-card-title>
  
        <v-card-text class="py-2 white--text text-center">
          {{ new Date().getFullYear() }} — <strong>Vuetify</strong>
        </v-card-text>
      </v-card>
    </v-footer>
  </v-app>
</template>



<script>
import Vue from 'vue';
import Vuetify from 'vuetify';
import '@mdi/font/css/materialdesignicons.css'
import 'vuetify/dist/vuetify.min.css'
import router from '../../routes.js';
import store from '../../store';
import {mapState, mapActions, mapGetters} from 'vuex';

Vue.use(Vuetify);

export default{
    vuetify: new Vuetify(),
    router: router,
    store: store,
    data() {
        return {
            drawer: null,
            icons: [
                'mdi-facebook',
                'mdi-twitter',
                'mdi-github',
                'mdi-instagram',
            ],
            items: [
                { title: 'Home', icon: 'mdi-view-dashboard' },
                { title: 'About', icon: 'mdi-forum' },
            ],
        }
    },
    methods: {
      ...mapActions(['user/logout', 'user/register']),
      onClickLogout() {
        this['user/logout']();
      },
    },
    computed: {
        ...mapState({
          user: state => state.user.user,
        }),
        ...mapGetters({
          isAuthenticated: 'user/isAuthenticated',
        }),
        initials() {
          return this.user ? this.user.name[0] : '';
        },
        name() {
          return this.user ? this.user.name : '';
        },
        email() {
          return this.user ? this.user.email : '';
        }
    }
}
</script>