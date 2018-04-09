<template>
  <div class="container">
    <div class="navbar">
      <div class="navbar__brand">
        <router-link to="/">Recipe Box</router-link>
      </div>
      <ul class="navbar__list">
        <li class="navbar__item" v-if="!check">
          <router-link to="/login">LOGIN</router-link>
        </li>
        <li class="navbar__item" v-if="!check">
          <router-link to="/register">REGISTER</router-link>
        </li>
        <li class="navbar__item" v-if="check">
          <a href="#" @click.stop="logout">LOGOUT</a>
        </li>
      </ul>
    </div>
    <div class="flash flash__success" v-if="flash.success">
      {{flash.success}}
    </div>
    <div class="flash flash__error" v-if="flash.error">
      {{flash.error}}
    </div>
    <router-view />
  </div>
</template>
<script>
import Flash from './helper/flash'
import Auth from './Store/auth'
import { post } from './helper/api'
export default {
  created() {
    Auth.initialize()
  },
  data() {
    return {
      flash: Flash.state,
      auth: Auth.state,
      a: null
    }
  },
  computed: {
    check() {
      if (this.auth.api_token && this.auth.user_id) {
        return true
      } else {
        return false
      }
    }
  },
  methods: {
    logout() {
      post('/api/logout')
      .then((res) => {
        if (res.data.logged_out) {
          Auth.remove()
          Flash.setSuccess('You have Successfully Logged Out')
          this.$router.push('/login')
        }
      })
    }
  }
}
</script>
<style lang="scss" scoped>
</style>
