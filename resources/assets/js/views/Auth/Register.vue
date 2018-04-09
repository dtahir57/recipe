<template>
  <div class="form">
    <form class="form" @submit.prevent="register">
      <h1 class="form__title">Create An Account</h1>
      <div class="form__group">
        <label>Name</label>
        <input type="text" class="form__control" v-model="form.name">
        <small class="error__control" v-if="e">{{ error.errors.name[0] }}</small>
      </div>
      <div class="form__group">
        <label>Email</label>
        <input type="email" class="form__control" v-model="form.email">
        <small class="error__control" v-if="e">{{ error.errors.email[0] }}</small>
      </div>
      <div class="form__group">
        <label>Password</label>
        <input type="password" class="form__control" v-model="form.password">
        <small class="error__control" v-if="e">{{ error.errors.password[0] }}</small>
      </div>
      <div class="form__group">
        <label>Confirm Password</label>
        <input type="password" class="form__control" v-model="form.password_confirmation">
      </div>
      <div class="form__group">
        <button :disabled="isProcessing" class="btn btn__primary">Register</button>
      </div>
    </form>
  </div>
</template>
<script>
import Flash from '../../helper/flash'
import { post } from '../../helper/api'
export default {
  data() {
    return {
      form: {
        name: '',
        email: '',
        password: '',
        password_confirmation: ''
      },
      e: false,
      error: {},
      isProcessing: false
    }
  },
  methods: {
    register() {
      this.isProcessing = true
      this.error = {}
      post('api/register', this.form)
      .then((res) => {
        if (res.data.register) {
          Flash.setSuccess('You have Successfully created an Account!')
          this.$router.push('/')
        }
        this.isProcessing = false
      }).catch((err) => {
        if(err.response.status === 422) {
          //console.log(err.response.data)
          this.e = true
          this.error = err.response.data
        }
        this.isProcessing = false
      })
    }
  }
}
</script>
<style lang="scss" scoped>
</style>
