export default {
  methods: {
    testMixin: function () {
      console.log('Mixin Called!')
    },
    getHeaders(token) {
      return {
        Accept: 'application/json',
        Authorization: `Bearer ${token}`
      }
    }
  }
}