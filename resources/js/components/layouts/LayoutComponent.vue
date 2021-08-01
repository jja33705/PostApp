<template>
  <v-app id="inspire">
    <v-navigation-drawer
      v-model="drawer"
      app
    >
        <v-list dense>
          <v-list-item
            v-for="item in items"
            :key="item.title"
            link
          >
            <v-list-item-icon>
              <v-icon>{{ item.icon }}</v-icon>
            </v-list-item-icon>
  
            <v-list-item-content>
              <v-list-item-title>{{ item.title }}</v-list-item-title>
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
              <template v-if="isLoggedIn">
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
                <v-dialog
                    v-model="loginDialog"
                    persistent
                    max-width="600px"
                >
                    <template v-slot:activator="{ on, attrs }">
                    <v-btn
                        depressed
                        rounded
                        text
                        v-bind="attrs"
                        v-on="on"
                    >
                        Sing Up
                    </v-btn>
                    </template>
                    <v-card>
                    <v-card-title>
                        <span class="text-h5">Sign Up</span>
                    </v-card-title>
                    <v-card-text>
                        <v-container>
                        <v-row>
                            <v-col cols="12">
                            <v-text-field
                                label="Email"
                                type="email"
                                required
                                v-model="loginForm.email"
                            ></v-text-field>
                            </v-col>
                            <v-col cols="12">
                            <v-text-field
                                label="Password"
                                type="password"
                                required
                                v-model="loginForm.password"
                            ></v-text-field>
                            </v-col>
                        </v-row>
                        </v-container>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                        color="blue darken-1"
                        text
                        @click="loginDialog = false"
                        >
                        Close
                        </v-btn>
                        <v-btn
                        color="blue darken-1"
                        text
                        @click="onClickLogin"
                        >
                        Sign up
                        </v-btn>
                    </v-card-actions>
                    </v-card>
                </v-dialog>
              
              
                <v-divider class="my-3"></v-divider>
              
              
                <v-dialog
                    v-model="registrationDialog"
                    persistent
                    max-width="600px"
                >
                    <template v-slot:activator="{ on, attrs }">
                    <v-btn
                        depressed
                        rounded
                        text
                        v-bind="attrs"
                        v-on="on"
                    >
                        Registration
                    </v-btn>
                    </template>
                    <v-card>
                    <v-card-title>
                        <span class="text-h5">Registration</span>
                    </v-card-title>
                    <v-card-text>
                        <v-container>
                        <v-row>
                            <v-col
                            cols="12"
                            >
                            <v-text-field
                                label="Name"
                                required
                                v-model="registerForm.name"
                            ></v-text-field>
                            </v-col>
                            <v-col cols="12">
                            <v-text-field
                                label="Email"
                                type="email"
                                required
                                v-model="registerForm.email"
                            ></v-text-field>
                            </v-col>
                            <v-col cols="12">
                            <v-text-field
                                label="Password"
                                type="password"
                                required
                                v-model="registerForm.password"
                            ></v-text-field>
                            </v-col>
                            <v-col cols="12">
                            <v-text-field
                                label="Password Confirmation"
                                type="password"
                                required
                                v-model="registerForm.password_confirmation"
                            ></v-text-field>
                            </v-col>
                        </v-row>
                        </v-container>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                        color="blue darken-1"
                        text
                        @click="registrationDialog = false"
                        >
                        Close
                        </v-btn>
                        <v-btn
                        color="blue darken-1"
                        text
                        @click="onClickRegister"
                        >
                        Save
                        </v-btn>
                    </v-card-actions>
                    </v-card>
                </v-dialog>
              </template>


            </div>
          </v-list-item-content>
        </v-card>
      </v-menu>
    </v-app-bar>

    <v-main>
      <router-view>
        
      </router-view>
    </v-main>
    <v-footer
      dark
      padless
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
import store from '../../store.js';
import {mapState, mapActions} from 'vuex';

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
            loginDialog: false,
            registrationDialog: false,
            loginForm: {
              email:'',
              password:'',
            },
            registerForm: {
              name: '',
              email: '',
              password: '',
              password_confirmation: '',
            }
        }
    },
    methods: {
      ...mapActions(['login', 'logout', 'register']),
      onClickLogin() {
        this.login(this.loginForm);
        this.LoginDialog = false;
      },
      onClickLogout() {
        this.logout();
      },
      onClickRegister() {
        this.register(this.registerForm);
        this.registrationDialog = false;
      },
    },
    computed: {
        ...mapState(['isLoggedIn', 'user']),
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