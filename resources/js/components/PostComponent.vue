<template>
<v-container>
    <v-row justify="end" dense>
        <template v-if="user && user.id === post.user.id">
            <v-btn @click="onClickDelete">삭제</v-btn>
            <v-btn :to="{name:'edit', params: {id: $route.params.id}}">수정</v-btn>
        </template>
    </v-row>
    <v-row justify="center" dense style="height: 80px;" align="center">
        <h1>{{ post.title }}</h1>
    </v-row>
    <v-row justify="end" dense style="height: 30px" align="center">
      <div> 
          조회수: {{ post.viewers }}
      </div>
    </v-row>
    <v-row justify="end" dense style="height: 40px" align="center">
      <div> 
          작성자: {{ post.user.name }}
      </div>
    </v-row>
    <v-row justify="end" dense style="height: 30px">
      <div>
        {{ getDate(post.created_at) }}
      </div>
    </v-row>
    <v-row justify="start" dense>
        <h6>{{ post.content }}</h6>
    </v-row>
    <v-row justify="center" dense>
        <v-btn tile @click="onClickLike">
            <v-icon left>
                mdi-heart
            </v-icon>
            {{ post.likes.length }}
        </v-btn>
    </v-row>
    <v-divider></v-divider>
    <v-row>
        <v-col cols="10">
            <i 
                v-for="(commentMessage, i) in commentMessages"
                :key="i"
            >
                {{ commentMessage }}
            </i>
            <v-textarea 
                label="comment" 
                rows="1"
                v-model="comment" 
                required
            ></v-textarea>
        </v-col>
        <v-col cols="2">
            <v-btn @click="onClickSubmitComment">save</v-btn>
        </v-col>

    </v-row>
    <v-card v-for="comment in post.comments"
        :key="comment.id"
    >    
        <v-card-title>{{ comment.user.name }}</v-card-title>
        <v-card-subtitle>{{ getDate(comment.created_at) }} <a v-if="user && user.id === comment.user.id" @click="onClickDeleteComment(comment.id)">삭제</a></v-card-subtitle>
        <v-card-text>{{ comment.comment }}</v-card-text>
    </v-card>
  </v-container>
</template>



<script> 
import {mapActions, mapState} from 'vuex';
export default {
    data() {
        return {
            post: {},
            comment: '',
            commentMessages: [],
        };
    },
    methods: {
        ...mapActions(['post/getPost', 'user/logout']),
        onClickDelete() {
            axios.delete('/api/post/' + this.$route.params.id, {
                headers: {
                    Authorization: 'Bearer ' + localStorage.getItem('token'),
                },
            })
            .then(() => {
                this.$router.push({name: 'index'});
            })
            .catch((err) => {
                if(err.response.data.messages === 'PostPolicy') {
                    alert('게시글을 삭제할 권한이 없습니다.');
                } else {
                    this['user/logout']();
                    alert('로그인이 필요합니다.')
                    this.$router.push({name: 'login'});
                }
            });
        },
        onClickSubmitComment() {
            axios.post('/api/comment/' + this.$route.params.id, {comment: this.comment}, {
                headers: {
                    Authorization: 'Bearer ' + localStorage.getItem('token'),
                },
            })
            .then(() => {
                this['post/getPost']({id: this.$route.params.id})
                .then((res) => {
                    this.post = res.data;
                })
                .catch((err) => {
                    console.log(err);
                });
                this.comment = '';
            })
            .catch((err) => {
                if(err.response.status === 403) {
                    if(err.response.data.messages.comment) {
                        this.commentMessages = err.response.data.messages.comment;
                    } else {
                        this.commentMessages = [];
                    }
                } else {
                    this['user/logout']();
                    alert('로그인이 필요합니다.')
                    this.$router.push({name: 'login'});
                }
            });
        },
        onClickLike() {
            axios.post('/api/post/like/' + this.$route.params.id, null, {
                headers: {
                    Authorization: 'Bearer ' + localStorage.getItem('token'),
                },
            })
            .then(() => {
                this['post/getPost']({id: this.$route.params.id})
                .then((res) => {
                    this.post = res.data;
                })
                .catch((err) => {
                    console.log(err);
                });
            })
            .catch((err) => {
                if(err.response.status === 500) {
                    alert('이미 좋아요를 누른 게시물입니다.')
                } else {
                    this['user/logout']();
                    alert('로그인이 필요합니다.')
                    this.$router.push({name: 'login'});
                }
            });
        },
        getDate(metaDate) {
            const dateObj = new Date(metaDate);
            return `${dateObj.getFullYear()}-${dateObj.getMonth()}-${dateObj.getDate()}   ${dateObj.getHours()}:${dateObj.getMinutes()}:${dateObj.getSeconds()}`;
        },
        onClickDeleteComment(id) {
            console.log('클릭함');
            axios.delete('/api/comment/' + id, {
                headers: {
                    Authorization: 'Bearer ' + localStorage.getItem('token'),
                },
            })
            .then(() => {
                this['post/getPost']({id: this.$route.params.id})
                .then((res) => {
                    this.post = res.data;
                })
                .catch((err) => {
                    console.log(err);
                });
            })
            .catch((err) => {
                console.log(err);
                if(err.response.data.messages === 'CommentPolicy') {
                    alert('댓글을 삭제할 권한이 없습니다.');
                } else {
                    this['user/logout']();
                    alert('로그인이 필요합니다.')
                    this.$router.push({name: 'login'});
                }
            });
        },
    },
    computed: {
        ...mapState({
            user: state => state.user.user,
        }),
    },
    mounted() {
        this['post/getPost']({id: this.$route.params.id})
        .then((res) => {
            this.post = res.data;
        })
        .catch((err) => {
            console.log(err);
        });
    },
}
</script>


