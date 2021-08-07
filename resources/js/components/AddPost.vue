<template>
    <v-container>
        <v-row justify="center" dense style="height: 100px;" align="center">
                <h2>게시글 작성</h2>
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
export default {
    data() {
        return {
            title: '',
            content: '',
        };
    },
    methods: {
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
                console.log(err);
            });
        },
    },
};
</script>