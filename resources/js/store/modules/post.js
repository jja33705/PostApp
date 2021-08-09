export default {
    namespaced: true,
    state() {
        return {
            page: 1,
            search: '',
        };
    },
    mutations: {
        setPage(state, page) {
            state.page = page;
        },
        setSearch(state, search) {
            state.search = search;
        },
    },
    actions: {
        getPosts(context, payload) {
            return new Promise((resolve, reject) => {
                axios.get(`/api/index?page=${context.state.page}&search=%${context.state.search}%`)
                .then((response) => {
                    resolve(response);
                })
                .catch((error) => {
                    reject(error);
                });
            });
        },
        getPost(context, payload) {
            return new Promise((resolve, reject) => {
                axios.get('/api/post/show/' + payload.id)
                .then((res) => {
                    resolve(res);
                })
                .catch((err) => {
                    reject(err);
                });
            });
        },
    },
};