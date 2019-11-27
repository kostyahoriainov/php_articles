<template>
    <div class="ui divided items">

        <div v-if="loading">Loading...</div>

        <div class="item" v-for="article in articles" :key="article.id">
            <div class="content">
                <p class="header">{{article.name}}</p>

                <div class="meta">
                    <span>{{article.category_name}}</span>
                </div>
                <div class="description">
                    <p>
                        {{article.text}}
                    </p>
                </div>
                <div class="extra content">
                    <a href="/articles/restore?id=<?= $article['id']; ?>"
                       class="ui basic green button">
                        Add
                    </a>
                    <a href="/articles/edit?id=<?= $article['id']; ?>"
                       class="ui basic blue button">
                        Edit
                    </a>
                    <a href="/articles/remove?id=<?= $article['id']; ?>"
                       class="ui basic red button">
                        Delete
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import { mapGetters } from 'vuex';

    export default {
        name: 'Articles',
        data() {
            return {
                state_name: this.$route.params.name
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
            ...mapGetters(['articles', 'loading'])
        }
    }
</script>