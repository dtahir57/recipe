<template>
  <div class="recipe__show">
    <div class="recipe__row">
      <div class="recipe__image">
        <div class="recipe__box">
          <img :src="`/images/${recipe.image}`" v-if="recipe.image" />
        </div>
      </div>
      <div class="recipe__details">
        <div class="recipe__details__inner">
          <small>Submitted By: {{recipe.user.name}}</small>
          <h1 class="recipe__title">{{recipe.name}}</h1>
          <p class="recipe__description">{{recipe.description}}</p>
          <div v-if="this.auth.api_token && this.auth.user_id === this.recipe.user.id">
            <router-link :to="`/recipes/${recipe.id}/edit`" class="btn btn__primary">Edit</router-link>
            <button type="button" class="btn btn__danger" :disabled="isRemoving" @click="remove">Delete</button>
          </div>
        </div>
      </div>
    </div>
    <div class="recipe__row">
      <div class="recipe__ingredients">
        <div class="recipe__box">
          <p class="recipe__sub__title">Ingredients</p>
          <ul>
            <li v-for="ingredient in recipe.ingredients">
              <span>{{ingredient.name}}</span>
              <span>{{ingredient.qty}}</span>
            </li>
          </ul>
        </div>
      </div>
      <div class="recipe__directions">
        <div class="recipe__direction__inner">
          <h3 class="recipe__sub__title">Directions</h3>
          <ul>
            <li v-for="(direction, i) in recipe.directions">
              <p>
                <strong>{{i+1}}</strong>
                {{direction.description}}
              </p>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import Auth from '../../Store/auth'
import { get, del } from '../../helper/api'
import Flash from '../../helper/flash'

export default {
  data() {
    return {
      auth: Auth.state,
      isRemoving: false,
      recipe: {
        user: {},
        ingredients: [],
        directions: []
      }
    }
  },
  created() {
      get(`/api/recipes/${this.$route.params.id}`).then((res) => {
        this.recipe = res.data.recipe
      }).catch((err) => {
        console.log(err.response.data)
      })
  },
  methods: {
    remove() {
      this.isRemoving = false
      del(`/api/recipes/${this.$route.params.id}`)
          .then((res) => {
            if (res.data.deleted) {
              Flash.setSuccess('Successfully removed!')
              this.$router.push('/')
            }
          })
    }
  }
}
</script>
<style lang="scss" scoped>
</style>
