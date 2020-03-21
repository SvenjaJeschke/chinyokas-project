<template>
  <div id="app">
    <b-navbar type="is-dark">
        <template slot="brand">
            <b-navbar-item tag="router-link" to="/">
                Chinyokas Dashboard
            </b-navbar-item>
        </template>
        <template slot="end">
            <b-navbar-item tag="router-link" to="/notes">
                Notizen
            </b-navbar-item>
            <b-navbar-item tag="router-link" to="/music">
                Musik
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
  name: 'App'
}
</script>

<style>
  main {
    margin: 20px;
  }
</style>
