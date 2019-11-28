<template>
    <div class="ui two column centered grid">
        <div class="column">
            <form id="form"
                  @submit="submitForm"
                  class="ui form"
                  style="margin-top: 40px">

                <h3 class="ui dividing header">Edit article</h3>

                <div class="field">
                    <label for="name">Article Name</label>
                    <input type="text"
                           name="name"
                           id="name"
                           v-model="article.name"
                           placeholder="Your article">
                </div>

                <div class="field">
                    <label for="text">Article</label>
                    <textarea id="text"
                              name="text"
                              rows="6"
                              v-model="article.text"
                    ></textarea>
                </div>

                <div class="field">
                    <label for="categories">Category</label>
                    <select id="categories"
                            name="category_id"
                            v-model="article.category_id">
                        <option v-for="category in categories"
                                :key="category.id"
                                :value="category.id">
                            {{ category.name }}
                        </option>
                    </select>
                </div>

                <button type="submit" class="ui button green">Edit</button>
            </form>
        </div>
    </div>
</template>
<script>
    import { mapGetters } from 'vuex';
    import router from '../routes';

    export default {
        name: 'ArticleEdit',
        data() {
            return {
                id: null,
                article: {}
            }
        },
        created() {
            this.id = this.$route.params.id;
            this.article = this.$store.getters.articles.find(article => article.id === this.id);
        },
        mounted() {
          this.$store.dispatch('FETCH_CATEGORIES');
        },
        computed: {
            ...mapGetters(['categories'])
        },
        methods: {
            submitForm(event) {
                event.preventDefault();
                router.push({path: '/articles/user/all'})
            }
        }
    };
</script>