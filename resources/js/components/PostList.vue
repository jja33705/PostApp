<template>
  <v-app id="inspire">
    <v-container>
      <v-row justify="end">
        <v-col cols="2">
          <v-btn :to="{name:'addPost'}">게시글 작성</v-btn>
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
import {mapState, mapActions, mapGetters} from 'vuex';
export default {
    data() {
        return {
            commentForm: [],
            page: 1,
        };
    },
    methods: {
      ...mapActions(['post/getPosts']),
      onClickPage(page) {
        this['post/getPosts']({page: page});
        this.$store.commit('post/setPage', page);
      },
      getDate(metaDate) {
        const dateObj = new Date(metaDate);
        return `${dateObj.getFullYear()}-${dateObj.getMonth()}-${dateObj.getDate()}-${dateObj.getHours()}:${dateObj.getMinutes()}:${dateObj.getSeconds()}`;
      }
    },
    mounted() {
      this.page = this.currentPage;
      this['post/getPosts']({page: this.page});
      
    },
    computed: {
      ...mapState({
        posts: state => state.post.posts,
        currentPage: state => state.post.page,
      }),
      ...mapGetters({
        pageLength: 'post/pageLength',
      }),
    }
};
</script>