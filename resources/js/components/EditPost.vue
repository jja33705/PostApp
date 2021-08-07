<template>
    <v-container>
        <v-row justify="center" dense style="height: 100px;" align="center">
                <h2>게시글 수정</h2>
        </v-row>
        <v-row>
            <v-col>
                <v-form @submit.prevent="onSubmit">
                    <v-text-field 
                        label="title"
                        v-model="title"
                    >
                    </v-text-field>
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
        };
    },
    methods: {
        ...mapActions(['post/getPost']),
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
                console.log(err);
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