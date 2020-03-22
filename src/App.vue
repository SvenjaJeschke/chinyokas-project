<template>
  <div id="app">
    <b-navbar type="is-black">
        <template slot="brand">
            <b-navbar-item tag="router-link" to="/">
                Chinyokas Dashboard
            </b-navbar-item>
        </template>
        <template slot="end">
            <b-navbar-item 
              v-for="(navItem, index) in navItems" 
              :key="index" 
              tag="router-link" 
              :to="navItem.route"
            >
                {{ navItem.name }}
            </b-navbar-item>
        </template>
    </b-navbar>
    <main class="content-wrapper">
      <router-view class="page-content"></router-view>
    </main>
  </div>
</template>

<script>
export default {
  name: 'App',
  data() {
    return {
      navItems: [
        { name: 'Blog', route: '/blog-view' },
        { name: 'Notes', route: '/notes' },
        { name: 'Music', route: '/music' }
      ]
    }
  }
}
</script>

<style>
 
  .content-wrapper {
    display: flex;
    justify-content: center;
}

.page-content {
    width: 75%;
    height: 100%;
    border: rgb(0, 217, 255);
    border-style: solid;
    border-width: 2px;
    border-top-width: 0px;
    background-color: rgba(0, 0, 0, 0.9);
    padding: 10px;
    border-bottom-left-radius: 5px;
    border-bottom-right-radius: 5px;
}
</style>
