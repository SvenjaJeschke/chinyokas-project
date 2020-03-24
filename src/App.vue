<template>
  <div 
    id="app"
    :style="{
      'background-attachment': 'fixed',
      'background-image': 'url(' + theme.backgroundImage + ')',
      'background-size': 'cover'
    }"
  >
    <b-navbar :type="theme.navbarType">
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
import {EventBus} from './event-bus.js';

export default {
  name: 'App',
  data() {
    return {
      theme: {},
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
        'min-height': '900px',
        'margin-bottom': '10px'
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
    this.getTheme();
  },
  mounted() {
    EventBus.$on('theme-was-changed', () => {
      this.getTheme()
    });
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
    },
    getTheme() {
      this.axios
        .get('http://localhost:8080/backend/api/theme/current.php')
        .then(response => {
          this.theme = response.data;
        })
        .catch(error => {
          console.log(error);
              this.$buefy.toast.open({
                  message: 'Something went wrong while loading the data... Please reload the page.',
                  type: 'is-danger'
              })
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
