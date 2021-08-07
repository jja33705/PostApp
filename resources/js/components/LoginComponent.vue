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
                    <i 
                        v-for="(emailMessage, i) in emailMessages"
                        :key="i"
                    >
                        {{ emailMessage }}
                    </i>
                    <v-text-field 
                        label="email" 
                        type="email" 
                        v-model="email"
                    ></v-text-field>
                    <i
                        v-for="(passwordMessage, i) in passwordMessages"
                        :key="i"
                    >
                        {{ passwordMessage }}
                    </i>
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
                {{ message }}
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
            emailMessages: [],
            password: '', 
            passwordMessages: [],
            message: '',
        };
    },
    methods: {
        ...mapActions(['user/login']),
        onSubmit() {
            this['user/login']({email: this.email, password: this.password})
            .then(() => {
                this.$router.go(-1);
            })
            .catch((err) => {
                if(err.response.status === 401) {
                    this.message = '아이디, 비밀번호를 다시 확인해 주세요';
                } else {
                    this.message = '';
                }
                if(err.response.status === 403) {
                    if(err.response.data.messages.email) {
                        this.emailMessages = err.response.data.messages.email;
                    } else {
                        this.emailMessages = [];
                    }
                    if(err.response.data.messages.password) {
                        this.passwordMessages = err.response.data.messages.password;
                    } else {
                        this.passwordMessages = [];
                    }
                } else {
                    this.emailMessages = [];
                    this.passwordMessages = [];
                }
            });
        },
    },
};
</script>