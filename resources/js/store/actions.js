let actions = {
    createPost({commit}, post) {
        axios.post('/api/posts', post)
            .then(res => {
                commit('CREATE_POST', res.data)
            }).catch(err => {

        })

    },
    fetchPosts({commit}) {
        axios.get('/api/posts')
            .then(res => {
                commit('FETCH_POSTS', res.data)
            }).catch(err => {

        })
    },
    deletePost({commit}, post) {
        axios.delete(`/api/posts/${post.id}`)
            .then(res => {
                if (res.data === 'ok')
                    commit('DELETE_POST', post)
            }).catch(err => {

        })
    }
}

export default actions
