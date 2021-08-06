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
                    <v-text-field
                        label="name"
                        type="text"
                        v-model="name"    
                    >
                    </v-text-field>
                    <v-text-field 
                        label="email" 
                        type="email" 
                        v-model="email"
                    ></v-text-field>
                    <v-text-field 
                        label="password" 
                        type="password" 
                        v-model="password"
                    >
                    </v-text-field>
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
                console.log(err);
            });
        },
    },
};
</script>