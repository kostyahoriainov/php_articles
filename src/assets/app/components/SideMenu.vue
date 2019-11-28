<template>
    <div class="ui vertical fluid tabular menu">
        <router-link active-class="active" class="item" to="/articles/user/all">
            All
        </router-link>
        <router-link active-class="active" class="item" to="/articles/user/active">
            Active
        </router-link>
        <router-link active-class="active" class="item" to="/articles/user/drafts">
            Drafts
        </router-link>
        <router-link active-class="active" class="item" to="/articles/user/removed">
            Removed
        </router-link>
    </div>
</template>

<script>
    export default {
        name: 'SideMenu'
    }
</script>