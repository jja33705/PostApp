<template>
    <v-container fluid>
        <v-row 
          dense
          v-for="post in posts"
          :key="post.id"
        >
          <v-col
            cols="12"
          >
            <v-card
              class="mx-auto"
              white
            >
              <v-card-title>
                <span class="text-h5 font-weight-bold">{{ post.title }}</span>
              </v-card-title>
          
              <v-card-text class="text-h6 font-weight-light">
                {{ post.content }}
              </v-card-text>
          
              <v-card-actions>
                <v-list-item class="grow">
                  <v-list-item-avatar color="grey darken-3">
                    <v-img
                      class="elevation-6"
                      alt=""
                      src="https://avataaars.io/?avatarStyle=Transparent&topType=ShortHairShortCurly&accessoriesType=Prescription02&hairColor=Black&facialHairType=Blank&clotheType=Hoodie&clotheColor=White&eyeType=Default&eyebrowType=DefaultNatural&mouthType=Default&skinColor=Light"
                    ></v-img>
                  </v-list-item-avatar>
          
                  <v-list-item-content>
                    <v-list-item-title>{{ post.user.name }}</v-list-item-title>
                  </v-list-item-content>
          
                  <v-row
                    align="center"
                    justify="end"
                  >
                    <v-btn
                      icon
                      color="pink"
                      @click="onClickHeart(post.id)"
                    >
                      <v-icon>mdi-heart</v-icon>
                    </v-btn>
                    <span class="subheading mr-2">{{ post.likes.length }}</span>
                  </v-row>
                </v-list-item>
              </v-card-actions>
              <v-row>
                <v-col
                  cols="10"
                >
                  <v-textarea
                    label="comment"
                    height="70"
                  ></v-textarea>
                </v-col>
                <v-col
                  cols="4"
                >
                  <v-btn>
                  </v-btn>
                </v-col>

              </v-row>
              <v-divider></v-divider>
              <v-card-subtitle class="pb-0">
                Number 10
              </v-card-subtitle>
          
              <v-card-text class="text--primary">
                <div>Whitehaven Beach</div>
          
                <div>Whitsunday Island, Whitsunday Islands</div>
              </v-card-text>
            </v-card>
          </v-col>
        </v-row>
        <v-row>
          <v-spacer></v-spacer>
          <v-dialog
            v-model="dialog"
            persistent
            max-width="600px"
          >
            <template v-slot:activator="{ on, attrs }">
              <v-btn
                class="mx-2"
                fab
                dark
                large
                color="cyan"
                v-bind="attrs"
                v-on="on"
              >
                <v-icon dark>
                  mdi-pencil
                </v-icon>
              </v-btn>
            </template>
            <v-card>
              <v-card-title>
                <span class="text-h5">Create Post</span>
              </v-card-title>
              <v-card-text>
                <v-container>
                  <v-row>
                    <v-col cols="12">
                      <v-text-field
                        label="title"
                        required
                        v-model="createPostForm.title"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12">
                      <v-textarea
                        label="content"
                        auto-grow
                        required
                        v-model="createPostForm.content"
                      ></v-textarea>
                    </v-col>
                  </v-row>
                </v-container>
              </v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                  color="blue darken-1"
                  text
                  @click="dialog = false"
                >
                  Close
                </v-btn>
                <v-btn
                  color="blue darken-1"
                  text
                  @click="onClickCreatePost"
                >
                  Save
                </v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog>
        </v-row>
    </v-container>
</template>

<script>
import {mapState, mapActions} from 'vuex';
export default {
    data() {
        return {
            dialog: false,
            createPostForm: {
              title: '',
              content: '',
            },
        };
    },
    methods: {
      ...mapActions(['getPosts', 'createPost']),
      onClickCreatePost() {
        this.createPost(this.createPostForm);
        this.dialog = false;
      },
      onClickHeart(id) {
        axios.post('/api/post/like/'+id, null, {
          headers: {
            Authorization: 'Bearer ' + localStorage.getItem('token'),
          },
        })
        .then((res) => {
          console.log(res);
          this.$store.dispatch('getPosts');
        })
        .catch((err) => {
          console.log(err);
        });
      },
    },
    mounted() {
      this.getPosts();
    },
    computed: {
      ...mapState(['posts']),
    },
};
</script>