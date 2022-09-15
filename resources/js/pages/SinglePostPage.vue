<template>
  <div class="container mt-3">
    <div v-if="post">
      <h1>{{post.title}}</h1>
      <img v-if="post.cover" :src="post.cover" :alt="post.title" class="mt-3">
      <div class="tags" v-if="post.tags.length > 0">
        <span v-for="tag in post.tags" :key="tag.id" class="badge bg-success mr-1">{{tag.name}}</span>
      </div>
      <p v-if="post.category">Categoria: {{post.category.name}}</p>
      <p class="content">{{post.content}}</p>
    </div>  
  </div>
</template>

<script>

export default {
  name:  'SinglePostPage',
  data(){
    return {
      post: null,
    }
  },
  methods: {
    getSinglePost() {
      axios.get('http://127.0.0.1:8000/api/posts/' + this.$route.params.slug)
      .then((response) => {
        if(response.data.success){
          this.post = response.data.results;
        } else {
          this.$router.push({name: '404'})
        }
        
      })
    }
  },
  mounted() {
    this.getSinglePost();
  }
}
</script>

<style lang="scss" scoped>
.tags{
  font-size: 20px;
  margin-bottom: 1rem;
}
p{
  font-size: 20px;

  &.content{
    font-size: 16px;
  }
}
</style>