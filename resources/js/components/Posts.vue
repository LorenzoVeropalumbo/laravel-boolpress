<template>

<div class="container">  
  <div>
    <h1 class="mt-5">Lista dei post</h1> 
    <div class="row row-cols-3">
      <div v-for="post in posts" :key="post.id" class="col"> 
        <Post :post="post"/>
      </div>
    </div>
    <nav aria-label="Page" class="mt-5">
    <ul class="pagination justify-content-center">
      <li class="page-item" :class="{'disabled' : currentPaginationPage == 1}">
        <a class="page-link" href="#" @click.prevent="getAxiosJson(currentPaginationPage - 1)">Previous</a>
      </li>
      <li class="page-item" :class="{'active' : currentPaginationPage == n}" v-for="n in totalPaginationPage" :key="n" >
        <a class="page-link" href="#" @click.prevent="getAxiosJson(n)">{{ n }}</a>
      </li>
      <li class="page-item" :class="{'disabled' : currentPaginationPage == totalPaginationPage}">
        <a class="page-link" href="#" @click.prevent="getAxiosJson(currentPaginationPage + 1)">Next</a>
      </li>
    </ul>
    </nav>
  </div>
</div>
</template>

<script>
import Post from "./Post";
export default {
  name: 'Posts',
  data() { 
    return{
      posts: [],
      totalPaginationPage: null,
      currentPaginationPage: 1,
    }   
  },
  components: {
    Post,
  },
  mounted(){
    this.getAxiosJson();
  },
  methods: {
    
    getAxiosJson(PageNumeber){
      axios.get('http://127.0.0.1:8000/api/posts', {
        params: {
          page: PageNumeber,
        }
      })
      .then((response)=>{
        this.posts = response.data.results.data;
        // console.log(response.data.results);
        this.totalPaginationPage = response.data.results.last_page;
        this.currentPaginationPage = response.data.results.current_page;
      })
    },
  }
}
</script>

<style lang="scss" scoped>

</style>