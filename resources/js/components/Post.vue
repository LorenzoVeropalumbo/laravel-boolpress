<template>
  <div class="card mt-4" style="width: 22rem;height: 220px;">
    <!-- <img class="card-img-top" src="..." alt="Card image cap"> -->
    <div class="card-body">
      <h5 class="card-title">{{ post.title }}</h5>
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