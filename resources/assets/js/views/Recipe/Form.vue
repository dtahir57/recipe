<template lang="html">
  <div class="recipe__show">
    <div class="recipe__header">
      <h3>{{action}} Recipe</h3>
      <div>
        <button type="button" class="btn btn__primary" @click="save" :disabled="isProcessing">Save</button>
        <button class="btn" @click="$router.back()" :disabled="isProcessing">Cancel</button>
      </div>
    </div>
    <div class="recipe__row">
      <div class="recipe__image">
        <div class="recipe__box">
          Image Upload
        </div>
      </div>
      <div class="recipe__details">
        <div class="recipe__details__inner">
          <div class="form__group">
            <label>Name</label>
            <input type="text" class="form__control" v-model="form.name" />
            <small class="error__control" v-if="error.name">
              {{error.name[0]}}
            </small>
          </div>
          <div class="form__group">
            <label>Description</label>
            <textarea type="text" class="form__control" v-model="form.description"></textarea>
            <small class="error__control" v-if="error.description">
              {{error.description[0]}}
            </small>
          </div>
        </div>
      </div>
    </div><!-- /.recipe__row -->
    <div class="recipe__row">
      <div class="recipe__ingredients">
        <div class="recipe__box">
          <h3 class="recipe__sub__title">Ingredients</h3>
          <div v-for="(ingredient, index) in form.ingredients" class="recipe__form">
            <input type="text" class="form__control" v-model="ingredient.name" :class="[error[`ingredients.${index}.name`] ? 'error__bg' : '']" />
            <input type="text" class="form__control form__qty" v-model="ingredient.qty" :class="[error[`ingredients.${index}.qty`] ? 'error__bg' : '']">
            <button class="btn btn__danger" @click="remove('ingredients', $index)">
              &times;
            </button>
            <button class="btn" @click="addIngredient">Add Ingredient</button>
          </div>
        </div><!-- /.recipe__box -->
      </div><!-- /.recipe__ingredients -->
      <div class="recipe__directions">
        <div class="recipe__direction__inner">
          <h3 class="recipe__sub__title">Directions</h3>
          <div v-for="(direction, index) in form.directions" class="recipe__form">
            <textarea type="text" class="form__control form__qty" v-model="direction.description" :class="[error[`directions.${index}.qty`] ? 'error__bg' : '']"></textarea>
            <button class="btn btn__danger" @click="remove('direction', $index)">
              &times;
            </button>
            <button class="btn" @click="addDirection">Add Direction</button>
          </div>
        </div><!-- /.recipe__box -->
      </div><!-- /.recipe__directions -->
    </div><!-- /.recipe__row -->
  </div>
</template>

<script>
import Vue from 'vue'
import Flash from '../../helper/flash'
import { get, post } from '../../helper/api'
export default {
  data() {
    return {
      form: {
        ingredirents: [],
        directions: []
      },
      error: {},
      isProcessing: false,
      initializeURL: `/api/recipes/create`,
      storeURL: `/api/recipes`,
      action: 'Create'
    }
  },
  created() {
    if (this.$route.meta.mode === 'edit') {
      this.initializeURL = `/api/recipes/${this.$route.params.id}/edit`
      this.storeURL = `/api/recipes/${this.$route.params.id}?_method=PUT`
      this.action = 'Update'
    }
    get(this.initializeURL)
        .then((res) => {
          Vue.set(this.$data, 'form', res.data.form)
        }).catch((err) => {
          console.log(err.response.data)
        })
  },
  methods: {
    save() {

    },
    addDirection() {
      this.form.directions.push({description: ''})
    },
    addIngredient() {
      this.form.ingredients.push({
        name: '',
        qty: ''
      })
    },
    remove(type, index) {
      if (this.form[type].length > 1) {
        this.form[type].splice(index, 1)
      }
    }
  }
}
</script>

<style lang="css">
</style>
