<template>
    <v-container>
        <v-row justify="center" dense style="height: 100px;" align="center">
                <h2>게시글 작성</h2>
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
                        required
                    ></v-textarea>
                    <v-btn type="submit">저장</v-btn>
                </v-form>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import {mapActions} from 'vuex';
export default {
    data() {
        return {
            title: '',
            content: '',
            titleMessages: [],
            contentMessages: [],
        };
    },
    methods: {
        ...mapActions(['user/logout']),
        onSubmit() {
            axios.post('/api/post/store', {title: this.title, content: this.content}, {
                headers: {
                    Authorization: 'Bearer ' + localStorage.getItem('token'),
                },
            })
            .then((res) => {
                this.$router.push({name: 'post', params: {id: res.data.id}});
            })
            .catch((err) => {
                if(err.response.status === 403) {
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
};
</script>