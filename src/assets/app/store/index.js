import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        articles: [],
        loading: true
    },
    mutations: {
        SET_ARTICLES: (state, payload) => {
            state.loading = false;
            state.articles = payload;
        },
    },
    actions: {
        FETCH_ARTICLES: (context) => {
            axios.get('/api/articles')
                .then(res => context.commit('SET_ARTICLES', res.data));
        }
    },
    modules: {
    },
    getters: {
        articles: state => state.articles,
        loading: state => state.loading
    }
})
