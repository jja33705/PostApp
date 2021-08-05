export default {
    namespaced: true,
    state() {
        return {
            posts: [],
            page: 1,
            post: {},
        };
    },
    getters: {
        pageLength(state) {
            return state.posts.length ? Math.ceil(state.posts[0].count/15) : 0;
        }
    },
    mutations: {
        setPosts(state, posts) {
            state.posts = posts;
        },
        setPost(state, post) {
            state.post = post;
        },
        setPage(state, page) {
            state.page = page;
        }
    },
    actions: {
        getPosts({
            commit
        }, payload) {
            axios.get('/api/index?page=' + payload.page)
            .then((response) => {
                commit('setPosts', response.data);
            })
            .catch((error) => {
                console.log(error);
            });
        },
        getPost({commit}, payload) {
            axios.get('/api/post/show/' + payload.id, {
                headers: {
                    Authorization: 'Bearer ' + localStorage.getItem('token'),
                },
            })
            .then((res) => {
                commit('setPost', res.data);
            })
            .catch((err) => {
                console.log(err);
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