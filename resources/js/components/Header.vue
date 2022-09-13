<template>
  <nav class="navbar navbar-light bg-light">
    <div class="container-fluid nav-links">
      <router-link class="navbar-brand" :to="{ name: 'Home'}">Home</router-link>
      <router-link class="navbar-brand" :to="{ name: 'About'}">About</router-link>
      <router-link class="navbar-brand" :to="{ name: 'Post'}">Posts</router-link>
      <a class="navbar-brand" href="/admin">Admin Page</a>
    </div>
  </nav>
</template>

<script>
export default {
  name: 'Header'
}
</script>

<style lang="scss" scoped>
 .container-fluid.nav-links{
    justify-content: flex-start;
    padding-block: 10px;

    a{
      font-size: 19px;
      font-weight: 700;
      margin-right: 1.3rem;
      text-transform: uppercase;
      color: white;

      &:hover{
        color: rgb(92, 92, 92);
      }
    }
  }
  nav{
    background-color: gray !important;
  }
</style>