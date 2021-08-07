<template>
    <v-container>
        <v-row>
            <v-col>
                <h2>회원가입</h2>
            </v-col>
        </v-row>
        <v-row>
            <v-col>
                <v-form @submit.prevent="onSubmit">
                    <i
                        v-for="(nameMessage, i) in nameMessages"
                        :key="i"
                    >
                        {{ nameMessage }}
                    </i>
                    <v-text-field
                        label="name"
                        type="text"
                        v-model="name"    
                    >
                    </v-text-field>
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
                    <v-text-field 
                        label="password" 
                        type="password" 
                        v-model="password"
                    >
                    </v-text-field>
                    <i
                        v-for="(passwordConfirmationMessage, i) in passwordConfirmationMessages"
                        :key="i"
                    >
                        {{ passwordConfirmationMessage }}
                    </i>
                    <v-text-field
                        label="password confirmation"
                        type="password"
                        v-model="password_confirmation"
                    >
                    </v-text-field>
                    <v-btn type="submit">회원가입</v-btn>
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
            name: '',
            email: '',
            password: '',
            password_confirmation: '',
            nameMessages: [],
            emailMessages: [],
            passwordMessages: [],
            passwordConfirmationMessages: [],
        };
    },
    methods: {
        ...mapActions(['user/register']),
        onSubmit() {
            this['user/register'](
                {
                    name: this.name, 
                    email: this.email, 
                    password: this.password, 
                    password_confirmation: this.password_confirmation}
            )
            .then(() => {
                this.$router.push({name: 'index'});
            })
            .catch((err) => {
                console.log(err.response);
                if(err.response.status === 403) {
                    if(err.response.data.messages.name) {
                        this.nameMessages = err.response.data.messages.name;
                    } else {
                        this.nameMessages = [];
                    }
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
                    if(err.response.data.messages.password_confirmation) {
                        this.passwordConfirmationMessages = err.response.data.messages.password_confirmation;
                    } else {
                        this.passwordConfirmationMessages = [];
                    }
                } else {
                    this.nameMessages = [];
                    this.emailMessages = [];
                    this.passwordMessages = [];
                    this.passwordConfirmationMessages = [];
                }
            });
        },
    },
};
</script>