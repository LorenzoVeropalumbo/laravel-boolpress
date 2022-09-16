<template>
  <nav class="navbar navbar-light bg-light">
    <div class="container-fluid nav-links">
      <router-link 
      v-for="link,index in navlinks" :key="index"
      class="navbar-brand" :class="{'active' : link.active == true}"
      :to="{ name: link.name}"><span @click="setActive(index)">{{link.label}}</span>   
      </router-link>
      
      <a class="navbar-brand" href="/admin">Admin Page</a>
    </div>
  </nav>
</template>

<script>
export default {
  name: 'Header',
  data() { 
    return{
      currentActive: 0,
      navlinks: [
        {
          name: 'Home',
          label: 'Home',
          active: true,
        },
        {
          name: 'About',
          label: 'About',
          active: false,
        },
        {
          name: 'Post',
          label: 'Post',
          active: false,
        },
        {
          name: 'Contact',
          label: 'Contact',
          active: false,
        },
      ],
    }   
  },
  methods: {
    setActive(index){
      if(this.currentActive != index){
        this.navlinks[this.currentActive].active = false;
        this.navlinks[index].active = true;
        this.currentActive = index;
      }
    }
  }
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

      &.active{
        color: rgb(92, 92, 92);
      }
    }
  }
  nav{
    background-color: gray !important;
  }
</style>