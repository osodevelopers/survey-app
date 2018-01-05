<template>
   <div>
      <el-row align="middle" type="flex" style="height: 100vh;">
        <el-col :span="6" :offset="9">
          <el-alert v-show="hasError"
            :title="error_msg"
            type="error">
          </el-alert>
          <div class="grid-content">
            <VuePassportLogin
              :api-url="apiUrl"
              :secret="secret"
              :client-id="clientId"
              button-class="btn btn-primary btn-block"
              control-class="form-group"
              input-class="form-control"
              @success="handleLogin"
              @failed="handleErrors"
            />
          </div>
          <a class="btn btn-primary btn-block" href="/register">Register</a>
        </el-col>
      </el-row>
   </div>
</template>

<script>
import VuePassportLogin from 'vue-passport'
import axios from 'axios'
var config = require("../../config/app.js");
var instance = axios.create();
// var config = new Config('./confid/app.js');

export default {
  mounted() {
    if(window.localStorage.getItem('user')){
      this.$router.push('/dashboard/survey');
    }
    // console.log(config.app.url);
  },
  components: { VuePassportLogin },
  data () {
      return {
        apiUrl: config.app.url,
        secret: config.app.secret,
        clientId: config.app.client_id,
        hasError: false,
        error_msg: ''
      }
  },
  methods: {
    handleLogin (payload) {
      this.$store.dispatch('setUser', payload.authUser);
      this.$store.dispatch('setToken', payload.authUser.access_token);
      window.localStorage.setItem('user',JSON.stringify(payload.authUser));
      window.localStorage.setItem('token',JSON.stringify(payload.authUser.access_token));
      instance.defaults.headers.common['Authorization'] = payload.headers.Authorization;
      this.$router.push('/dashboard/survey');
    },
    handleErrors (errors) {
      console.log(errors.response.data.message);
      this.hasError = true;
      this.error_msg = errors.response.data.message;
      // alert('Authorization error' + errors);
    }
  }
}
</script>

<style type="scss">
  .label{
    color: #000;
  }
  
</style>