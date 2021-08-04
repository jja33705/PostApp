import Vue from 'vue';
import Vuex from 'vuex';
import post from './modules/post';
import user from './modules/user';
import createPersistedState from 'vuex-persistedstate';

Vue.use(Vuex);

export default Vuex.Store({
    modules: {
        post,
        user
    },
    plugins: [
        createPersistedState(),
    ],
});