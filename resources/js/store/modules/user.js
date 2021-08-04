export default {
    namespaced: true,
    state() {
        return {
            isLoggedIn: !!localStorage.getItem('token'),
            user: null,
        }
    },
    mutations: {
        loginUser(state) {
            state.isLoggedIn = true;
        },
        logoutUser(state) {
            state.isLoggedIn = false;
        },
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
                const tokenResponse = await axios.post('/api/login', payload);
                localStorage.setItem('token', tokenResponse.data.access_token);
                const userResponse = await axios.get('/api/user', {
                    headers: {
                        Authorization: 'Bearer ' + localStorage.getItem('token'),
                    },
                });
                context.commit('setUser', userResponse.data);
                context.commit('loginUser');
                payload.email = '';
                payload.password = '';
            } catch (error) {
                console.log(error);
            }
        },
        logout({
            commit
        }) {
            localStorage.removeItem('token');
            commit('setUser', null);
            commit('logoutUser');
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