<template>
  <div class="recipe__list">
    <div class="recipe__item" v-for="recipe in recipes">
      <router-link class="recipe_inner" :to="`/recipes/${recipe.id}`">
        <img :src="`/images/${recipe.image}`" v-if="recipe.image" />
        <p class="recipe__name">{{recipe.name}}</p>
      </router-link>
    </div>
  </div>
</template>
<script>
import { get } from '../../helper/api'
export default {
  data() {
    return {
      recipes: []
    }
  },
  created() {
    get('/api/recipes')
      .then((res) => {
        this.recipes = res.data.recipes
      }).catch((err) => {
        console.log(err.response.data)
      })
  }
}
</script>
<style lang="scss" scoped>
</style>
