import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        articles: [],
        loading: false,
        categories: []
    },
    mutations: {
        SET_ARTICLES: (state, payload) => {
            state.loading = false;
            state.articles = payload;
        },
        LOADING_ARTICLES: (state, payload) => {
            state.loading = payload;
        },
        REMOVE_ARTICLE: (state, payload) => {
            state.articles = payload;
        },
        RESTORE_ARTICLE: (state, payload) => {
            state.articles = payload;
        },
        FETCH_CATEGORIES: (state, payload) => {
            state.categories = payload;
        }
    },
    actions: {
        FETCH_ARTICLES: (context, skipCache = false) => {
            if (context.state.articles.length || skipCache) {
                return;
            }

            context.commit('LOADING_ARTICLES', true);
            return axios.get('/api/articles')
                .then(res => context.commit('SET_ARTICLES', res.data));
        },
        REMOVE_ARTICLE: (context, payload) => {
            let data = {
                article_id: payload.article_id
            };
            return axios.post('/api/articles/remove', data)
                .then(({ data }) => {
                    $.unblockUI();
                    context.commit('REMOVE_ARTICLE', data)
                });
        },
        RESTORE_ARTICLE: (context, payload) => {
            let data = {
                article_id: payload.article_id
            };
            return axios.post('/api/articles/restore', data)
                .then(({ data }) => {
                    $.unblockUI();
                    context.commit('RESTORE_ARTICLE', data);
                });
        },
        FETCH_CATEGORIES: (context) => {
            return axios.get('/api/categories')
                .then(({ data }) => {
                    console.log(data);
                    context.commit("FETCH_CATEGORIES", data)
                })
        }
    },
    modules: {
    },
    getters: {
        articles: state => state.articles,
        loading: state => state.loading,
        categories: state => state.categories
    }
})
