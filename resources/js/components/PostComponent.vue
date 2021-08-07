<template>
<v-container>
    <v-row justify="end" dense>
        <v-btn @click="onClickDelete">삭제</v-btn>
        <v-btn :to="{name:'edit', params: {id: $route.params.id}}">수정</v-btn>
    </v-row>
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
        <v-col cols="10">
            <v-textarea 
                label="comment" 
                rows="1"
                v-model="comment" 
                required
            ></v-textarea>
        </v-col>
        <v-col cols="2">
            <v-btn @click="onClickSubmitComment(post.id)">save</v-btn>
        </v-col>

    </v-row>
    <v-card v-for="comment in post.comments"
        :key="comment.id"
    >    
        <v-card-title>{{ comment.user.name }}</v-card-title>
        <v-card-subtitle>{{ new Date(comment.created_at) }}</v-card-subtitle>
        <v-card-text>{{ comment.comment }}</v-card-text>
    </v-card>
  </v-container>
</template>



<script> 
import {mapActions} from 'vuex';
export default {
    data() {
        return {
            post: {},
            comment: '',
        };
    },
    methods: {
        ...mapActions(['post/getPost']),
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
                console.log(err.response);
            });
        },
        onClickSubmitComment(id) {
            axios.post('/api/comment/' + id, {comment: this.comment}, {
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
                console.log(err);
            });
        },
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


