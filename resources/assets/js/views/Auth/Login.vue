<template>
  <div class="form">
    <form class="form" @submit.prevent="login">
      <h1 class="form__title">Login Into Your Account</h1>
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
        <button :disabled="isProcessing" class="btn btn__primary">Login</button>
      </div>
    </form>
  </div>
</template>
<script>
import Flash from '../../helper/flash'
import Auth from '../../Store/auth'
import { post } from '../../helper/api'
export default {
  data() {
    return {
      form: {
        email: '',
        password: ''
      },
      e: false,
      error: {},
      isProcessing: false
    }
  },
  methods: {
    login() {
      this.isProcessing = true
      this.error = {}
      post('api/login', this.form)
      .then((res) => {
        if (res.data.authenticated) {
          Auth.set(res.data.api_token, res.data.user_id)
          Flash.setSuccess('You have Successfully logged In!')
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
