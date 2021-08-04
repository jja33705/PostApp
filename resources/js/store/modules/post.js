export default {
    state() {
        return {
            posts: [],
        }
    },
    mutations: {
        setPosts(state, posts) {
            state.posts = posts;
        },
    },
    actions: {
        getPosts({
            commit
        }) {
            axios.get('/api/index')
                .then((response) => {
                    commit('setPosts', response.data);
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        async createPost(context, payload) {
            try {
                await axios.post('/api/post/store', payload, {
                    headers: {
                        Authorization: 'Bearer ' + localStorage.getItem('token'),
                    },
                })
                context.dispatch('getPosts');
                payload.title = '';
                payload.content = '';
            } catch (error) {
                console.log(error);
            };
        },
    },
};