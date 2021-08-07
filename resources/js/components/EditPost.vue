<template>
    <v-container>
        <v-row justify="center" dense style="height: 100px;" align="center">
                <h2>게시글 수정</h2>
        </v-row>
        <v-row>
            <v-col>
                <v-form @submit.prevent="onSubmit">
                    <i 
                        v-for="(titleMessage, i) in titleMessages"
                        :key="i"
                    >
                        {{ titleMessage }}
                    </i>
                    <v-text-field 
                        label="title"
                        v-model="title"
                    >
                    </v-text-field>
                    <i 
                        v-for="(contentMessage, i) in contentMessages"
                        :key="i"
                    >
                        {{ contentMessage }}
                    </i>
                    <v-textarea 
                        label="content"
                        v-model="content"
                    ></v-textarea>
                    <v-btn type="submit">저장</v-btn>
                </v-form>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import {mapActions} from 'vuex';
export  default {
    data() {
        return {
            title: '',
            content: '',
            titleMessages: [],
            contentMessages: [],
        };
    },
    methods: {
        ...mapActions(['post/getPost', 'user/logout']),
        onSubmit() {
            axios.patch('/api/post/' + this.$route.params.id, {title: this.title, content: this.content}, {
                headers: {
                    Authorization: 'Bearer ' + localStorage.getItem('token'),
                },
            })
            .then(() => {
                this.$router.push({name: 'post', params: {id: this.$route.params.id}});
            })
            .catch((err) => {
                if(err.response.status === 403) {
                    if(err.response.data.messages === 'PostPolicy') {
                    alert('다른 유저의 게시글을 수정할 수 없습니다.');
                    this.$router.push('index');
                    }
                    if(err.response.data.messages.title) {
                        this.titleMessages = err.response.data.messages.title;
                    } else {
                        this.titleMessages = [];
                    }
                    if(err.response.data.messages.content) {
                        this.contentMessages = err.response.data.messages.content;
                    } else {
                        this.contentMessages = [];
                    }
                } else {
                    this['user/logout']();
                    alert('로그인이 필요합니다.')
                    this.$router.push({name: 'login'});
                }
            });
        },
    },
    mounted() {
        this['post/getPost']({id: this.$route.params.id})
        .then((res) => {
            this.title = res.data.title;
            this.content = res.data.content;
        })
        .catch((err) => {
            console.log(err);
        });
    },
};
</script>