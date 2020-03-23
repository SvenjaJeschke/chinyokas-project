<template>
  <div 
    id="app"
    :style="{
      'background-attachment': 'fixed',
      'background-image': 'url(' + theme.backgroundImage + ')'
    }"
  >
    <b-navbar :type="theme.navbarType" fixed-top>
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
      <router-view :style="pageContent"></router-view>
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
      ],
      theme: {
        backgroundImage: 'https://wallpapermemory.com/uploads/676/fantasy-forest-wallpaper-full-hd-1920x1080-20410.jpg',
        borderColor: 'rgb(0, 217, 255)',
        navbarType: 'is-dark'
      }
    }
  },
  computed: {
    pageContent() {
      return {
        'width': '75%',
        'border': this.theme.borderColor,
        'border-style': 'solid',
        'border-width': '2px',
        'border-top-width': '0px',
        'background-color': 'rgba(0, 0, 0, 0.9)',
        'padding': '10px',
        'border-bottom-left-radius': '5px',
        'border-bottom-right-radius': '5px',
        'min-height': '900px'
      }
    }
  }
}
</script>

<style>
.content-wrapper {
  display: flex;
  justify-content: center;
}
</style>
