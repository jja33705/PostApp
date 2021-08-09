<template>
  <v-app id="inspire">
    <v-container>
      <v-row justify="end">
        <v-col cols="2">
          <v-btn :to="{name:'addPost'}">게시글 작성</v-btn>
        </v-col>
      </v-row>
      <v-row>
        <v-col cols="10">
          <v-text-field placeholder="search" v-model="search"></v-text-field>
        </v-col>
        <v-col>
          <v-btn @click="onClickSearch">검색</v-btn>
        </v-col>
      </v-row>
      <v-row>
        <v-col>
        <v-simple-table>
          <template v-slot:default>
            <thead>
              <tr>
                <th class="text-left">
                  제목
                </th>
                <th class="text-left">
                  작성자
                </th>
                <th class="text-left">
                  작성일
                </th>
                <th class="text-left">
                  조회수
                </th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="post in posts"
                :key="post.id"
              >
                <td><router-link :to="{name: 'post', params: { id: post.id }}">{{ post.title }}</router-link></td>
                <td>{{ post.user.name }}</td>
                <td>{{ getDate(post.created_at) }}</td>
                <td>{{ post.viewers }}</td>
              </tr>
            </tbody>
          </template>
        </v-simple-table>
        </v-col>
      </v-row>
    </v-container>


    <v-pagination
      v-model="page"
      @input="onClickPage"
      :length="pageLength"
    ></v-pagination>
  </v-app>
</template>

<script>
import {mapState, mapActions} from 'vuex';
export default {
    data() {
        return {
            posts: [],
            search: '',
            page: 1,
        };
    },
    methods: {
      ...mapActions(['post/getPosts']),
      onClickPage(page) {
        this.$store.commit('post/setPage', page);
        this['post/getPosts']()
        .then((res) => {
          this.posts = res.data;
        })
        .catch((err) => {
          console.log(err);
        });
      },
      getDate(metaDate) {
        const dateObj = new Date(metaDate);
        return `${dateObj.getFullYear()}-${dateObj.getMonth()}-${dateObj.getDate()}   ${dateObj.getHours()}:${dateObj.getMinutes()}:${dateObj.getSeconds()}`;
      },
      onClickSearch() {
        this.$store.commit('post/setSearch', this.search)
        this.$store.commit('post/setPage', 1);
        this['post/getPosts']()
        .then((res) => {
          this.posts = res.data;
          console.log(res);
        })
        .catch((err) => {
          console.log(err);
        });
      }
    },
    mounted() {
      this.page = this.currentPage;
      this.search = this.currentSearch;
      this['post/getPosts']()
      .then((res) => {
        this.posts = res.data;
      })
      .catch((err) => {
        console.log(err);
      });
    },
    computed: {
      ...mapState({
        currentPage: state => state.post.page,
        currentSearch: state => state.post.search,
      }),
      pageLength() {
        return this.posts.length ? Math.ceil(this.posts[0].count/15) : 0;
      },
    },
};
</script>