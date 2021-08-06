<template>
    <v-container>
        <v-row>
            <v-col>
                <h2>로그인</h2>
            </v-col>
        </v-row>
        <v-row>
            <v-col>
                <v-form @submit.prevent="onSubmit">
                    <i>{{ emailMessage }}</i>
                    <v-text-field 
                        label="email" 
                        type="email" 
                        v-model="email"
                    ></v-text-field>
                    <i>{{ passwordMessage }}</i>
                    <v-text-field label="password" type="password" v-model="password"></v-text-field>
                    <v-btn type="submit">로그인</v-btn>
                </v-form>
            </v-col>
        </v-row>
        <v-row>
            <v-col>
                <v-alert v-if="message"
                    border="bottom"
                    color="pink darken-1"
                    dark
                >
                </v-alert>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import {mapActions} from 'vuex';
export default{
    data() {
        return {
            email: '',
            emailMessage: '',
            password: '', 
            passwordMessage: '',
            message: '',
        };
    },
    methods: {
        ...mapActions(['user/login']),
        onSubmit() {
            this['user/login']({email: this.email, password: this.password})
            .then(() => {
                this.$router.push({name: 'index'});
            })
            .catch((err) => {
                console.log(err.response);
                console.log(err.response.status);
                console.log(typeof(err.response.status));
                if(err.response.status == 401) {
                    console.log('ㅇㅇㅇㅇ');
                    this.message = '아이디, 비밀번호를 다시 확인해 주세요';
                }
                if(err.response.data.messages.email) {
                    this.emailMessage = err.response.data.messages.email[0];
                }
                if(err.response.data.messages.password) {
                    this.passwordMessage = err.response.data.messages.password[0];
                }

            });
        },
    },
};
</script>