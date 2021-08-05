<template>
  <v-app id="inspire">
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
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="post in posts"
            :key="post.id"
          >
            <td><router-link :to="{name: 'post', params: { id: post.id }}">{{ post.title }}</router-link></td>
            <td>{{ post.user.name }}</td>
            <td>{{ new Date(post.created_at) }}</td>
          </tr>
        </tbody>
      </template>
    </v-simple-table>
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
            dialog: false,
            createPostForm: {
              title: '',
              content: '',
            },
            commentForm: [],
            page: 1,
        };
    },
    methods: {
      ...mapActions(['post/getPosts', 'post/createPost']),
      onClickCreatePost() {
        this['createPost'](this.createPostForm);
        this.dialog = false;
      },
      onClickPage(page) {
        this['post/getPosts']({page: page});
        this.$store.commit('post/setPage', page);
      },
      onClickHeart(id) {
        axios.post('/api/post/like/'+id, null, {
          headers: {
            Authorization: 'Bearer ' + localStorage.getItem('token'),
          },
        })
        .then((res) => {
          console.log(res);
          this['post/getPosts'](this.page);
        })
        .catch((err) => {
          console.log(err);
        });
      },
      onClickSubmitComment(id) {
        axios.post('/api/comment/store/' + id, {comment: this.commentForm[id]}, {
          headers: {
            Authorization: 'Bearer ' + localStorage.getItem('token'),
          },
        })
        .then((res) => {
          console.log(res);
          this['post/getPosts']();
          this.commentForm[id] = '';
        })
        .catch((err) => {
          console.log(err);
        });
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