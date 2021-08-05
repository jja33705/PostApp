<template>
<v-container>
    <template v-if="user.name === post.user.name">
        <v-row justify="end" dense>
            <v-btn @click="onClickDelete">삭제</v-btn>
            <v-btn>수정</v-btn>
        </v-row>
    </template>
    <v-row justify="center" dense style="height: 80px;" align="center">
        <h1>{{ post.title }}</h1>
    </v-row>
    <v-row justify="end" dense style="height: 40px" align="center">
      <div> 
          {{ post.user.name }}
      </div>
    </v-row>
    <v-row justify="end" dense style="height: 30px">
      <div>
        {{ new Date(post.created_at) }}
      </div>
    </v-row>
    <v-row justify="center" dense>
        <h6>{{ post.content }}</h6>
    </v-row>
    <v-divider></v-divider>
    <v-row>
        <v-textarea 
            label="comment" 
            rows="1"
            v-model="comment" 
            required
        ></v-textarea>
        <v-btn @click="onClickSubmitComment(post.id)">save</v-btn>
    </v-row>
    <v-card v-for="comment in post.comments"
        :key="comment.id"
    >    
        <v-card-title>{{ comment.commenter }}</v-card-title>
        <v-card-subtitle>{{ new Date(comment.created_at) }}</v-card-subtitle>
        <v-card-text>{{ comment.comment }}</v-card-text>
    </v-card>
  </v-container>
</template>



<script> 
import {mapState} from 'vuex';
export default {
    data() {
        return {
            post: null,
            comment: '',
        };
    },
    methods: {
        onClickDelete() {
            axios.delete('/api/post/' + this.$route.params.id, {
                headers: {
                    Authorization: 'Bearer ' + localStorage.getItem('token'),
                },
            })
            .then((res) => {
                this.$router.push({name: 'index'});
            })
            .catch((err) => {
                console.log(err);
            });
        },
    },
    computed: {
        ...mapState({
            user: state => state.user.user,
        })
    },
    mounted() {
        axios.get('/api/post/show/' + this.$route.params.id, {
            headers: {
                Authorization: 'Bearer ' + localStorage.getItem('token'),
            },
        })
        .then((res) => {
            this.post = res.data;
            console.log(res);
        })
        .catch((err) => {
            console.log(err);
        });
    },
}
</script>


