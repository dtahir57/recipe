export default {
  state: {
    success: null,
    error: null
  },
  setSuccess(message) {
    this.state.success = message
    setTimeout(() => {
      this.removeSuccess()
    }, 3000)
  },
  setError(error) {
    this.state.error = error
    setTimeout(() => {
      this.removeError()
    }, 10000)
  },
  removeSuccess() {
    this.state.success = null
  },
  removeError() {
    this.state.error = null
  }
}
