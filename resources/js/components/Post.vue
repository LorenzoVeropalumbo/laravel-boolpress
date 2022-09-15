<template>
  <div class="card mt-4">
    <!-- <img class="card-img-top" src="..." alt="Card image cap"> -->
    <div class="card-body">
      <h5 class="card-title">{{ post.title }}</h5>
      <img class="card-img-top" :src="post.cover" :alt="post.title">  
      <p class="card-text">{{ getSlicedText(post.content) }}</p>
      <router-link 
      :to="{
        name: 'Single-Post', 
        params: { slug: post.slug }
      }" 
      class="btn btn-primary">Visualizza l'articolo completo
      </router-link>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Post',
  props: {
    post: Object
  },
    methods: {
    getSlicedText(text){
      
      if(text.length > 120){
        text = text.slice(0, 120) + '...';
      }

      return text;
    }
  }
}
</script>

<style>

</style>