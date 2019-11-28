<template>
    <div class="ui divided items" id="articles">

        <div v-if="loading">
            <Loader></Loader>
        </div>

        <div v-if="!loading && !filterArticles.length" class="row">
            <NoArticles></NoArticles>
        </div>

        <div class="item" v-for="(article, index) in filterArticles" :key="article.id">
            <div class="content">
                <p class="header">{{ article.name }}</p>

                <div class="meta">
                    <span>{{ article.category_name }}</span>
                </div>
                <div class="description">
                    <p>
                        {{ article.text }}
                    </p>
                </div>

                <div v-if="Number(article.status) === STATUS_ACTIVE" class="extra content">
                    <router-link :to="{name: 'article-edit', params: {id: article.id}}"
                       class="ui basic blue button">
                        Edit
                    </router-link>
                    <a v-on:click="removeArticle(article.id, index)"
                       class="ui basic red button">
                        Delete
                    </a>
                </div>

                <div v-if="Number(article.status) === STATUS_DRAFTS" class="extra content">
                    <a v-on:click="restoreArticle(article.id, index)"
                       class="ui basic green button">
                        Add
                    </a>
                    <router-link :to="{name: 'article-edit', params: {id: article.id}}"
                       class="ui basic blue button">
                        Edit
                    </router-link>
                    <a  v-on:click="removeArticle(article.id, index)"
                       class="ui basic red button">
                        Delete
                    </a>
                </div>

                <div v-if="Number(article.status) === STATUS_REMOVED" class="extra content">
                    <a v-on:click="restoreArticle(article.id, index)"
                       class="ui basic green button">
                        Restore
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import { mapGetters } from 'vuex';
    import Loader from "../components/Loader";
    import NoArticles from "../components/NoArticles";

    const ARTICLE_REMOVED_STATUS = 'removed';
    const ARTICLE_ACTIVE_STATUS = 'active';
    const ARTICLE_DRAFTS_STATUS = 'drafts';


    export default {
        name: 'Articles',
        components: {
            NoArticles,
            Loader
        },
        data() {
            return {
                state_name: this.$route.params.name,
                STATUS_REMOVED: 1,
                STATUS_ACTIVE: 0,
                STATUS_DRAFTS: 2
            }
        },
        mounted() {
            this.$store.dispatch('FETCH_ARTICLES');
        },
        beforeRouteUpdate(to, from, next) {
            this.state_name = to.params.name;
            next();
        },
        computed: {
            ...mapGetters(['articles', 'loading']),
            filterArticles: function () {
                if (!this.state_name) {
                    return this.articles;
                }
                switch (this.state_name) {
                    case ARTICLE_REMOVED_STATUS:
                        return this.articles.filter(article => Number(article.status) === 1);
                    case ARTICLE_DRAFTS_STATUS:
                        return this.articles.filter(article => Number(article.status) === 2);
                    case ARTICLE_ACTIVE_STATUS:
                        return this.articles.filter(article => Number(article.status) === 0);
                    default:
                        return this.articles;
                }
            }
        },
        methods: {
            removeArticle(article_id, index) {
                $.blockUI();
                const article_data = {
                    article_id,
                    index
                };
                this.$store.dispatch('REMOVE_ARTICLE', article_data);
            },
            restoreArticle(article_id, index) {
                $.blockUI();
                const article_data = {
                    article_id,
                    index
                };
                this.$store.dispatch('RESTORE_ARTICLE', article_data);
            }
        }
    }
</script>