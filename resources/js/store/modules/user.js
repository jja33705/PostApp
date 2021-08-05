export default {
    namespaced: true,
    state() {
        return {
            user: null,
        }
    },
    getters: {
        isAuthenticated(state) {
            if (state.user == null) return false;
            return true; 
        }
    },
    mutations: {
        setUser(state, user) {
            state.user = user;
        },
        setPosts(state, posts) {
            state.posts = posts;
        },
    },
    actions: {
        async login(context, payload) {
            try {
                const token = await axios.post('/api/login', payload);
                localStorage.setItem('token', token.data.access_token);
                const user = await axios.get('/api/user', {
                    headers: {
                        Authorization: 'Bearer ' + localStorage.getItem('token'),
                    },
                });
                context.commit('setUser', user.data);
                payload.email = '';
                payload.password = '';
            } catch (error) {
                console.log(error.response);
            }
        },
        logout({
            commit
        }) {
            localStorage.removeItem('token');
            commit('setUser', null);

        },
        async register(context, payload) {
            try {
                await axios.post('/api/register', payload);
                await context.dispatch('login', {
                    email: payload.email,
                    password: payload.password
                });
                payload.name = '';
                payload.email = '';
                payload.password = '';
                payload.password_confirmation = '';
            } catch (error) {
                console.log(error);
            }
        },
    },
}