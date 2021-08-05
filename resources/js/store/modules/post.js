export default {
    namespaced: true,
    state() {
        return {
            posts: [],
            page: 1,
        }
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