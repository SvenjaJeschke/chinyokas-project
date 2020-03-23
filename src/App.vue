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
      theme: {
        backgroundImage: 'https://wallpapermemory.com/uploads/676/fantasy-forest-wallpaper-full-hd-1920x1080-20410.jpg',
        borderColor: 'rgb(0, 217, 255)',
        navbarType: 'is-dark'
      },
      admin: false
    }
  },
  computed: {
    pageContent() {
      return {
        'width': '75%',
        'border-color': this.theme.borderColor,
        'border-style': 'solid',
        'border-width': '2px',
        'border-top-width': '0px',
        'background-color': 'rgba(0, 0, 0, 0.9)',
        'padding': '10px',
        'border-bottom-left-radius': '5px',
        'border-bottom-right-radius': '5px',
        'min-height': '900px'
      }
    },
    navItems() {
      let navItems = [
        { name: 'Blog', route: '/blog' },
        { name: 'Music', route: '/music' },
        { name: 'Album', route: '/album' }
      ];
      const adminItems = [
        { name: 'Theme', route: '/theme' }, 
        { name: 'Notes', route: '/notes' }
      ]
      if (this.admin) {
        navItems = navItems.concat(adminItems);
      }
      return navItems;
    }
  },
  watch: {
    admin() {
      this.checkAdmin();
    }
  },
  created() {
    this.checkAdmin();
  },
  methods: {
    checkAdmin() {
      const password = localStorage.getItem('password');
      this.axios
        .get(
          'http://localhost:8080/backend/api/auth/checkadmin.php',
          { params: { password: password } },
          { headers: { 'Content-Type': 'application/x-www-form-urlencoded' } })
        .then(response => {
          this.admin = response.data.admin;
        })
    }
  }
}
</script>

<style>
.content-wrapper {
  display: flex;
  justify-content: center;
}
h1 {
  border-bottom: white;
  border-bottom-style: solid;
  border-bottom-width: 1px;
}
</style>
