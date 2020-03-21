<template>
  <div id="app">
    <b-navbar type="is-dark">
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
    <main>
      <router-view></router-view>
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
  main {
    margin: 20px;
  }
</style>
