<template>
    <div id="app">
        <div class="ui grid" style="margin-top: 50px">
            <div class="row">
                <div class="three wide column">
                    <SideMenu></SideMenu>
                </div>
                <div class="ten wide column">
                    <router-view></router-view>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import SideMenu from '../components/SideMenu';

    export default {
        name: 'ArticlesList',
        components: {SideMenu}
    }

</script>
