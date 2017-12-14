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
              button-class="btn btn-primary"
              control-class="form-group"
              input-class="form-control"
              @success="handleLogin"
              @failed="handleErrors"
            />
          </div>
        </el-col>
      </el-row>
   </div>
</template>

<script>
import VuePassportLogin from 'vue-passport'
import axios from 'axios'

var instance = axios.create();

export default {
  mounted() {

  },
  components: { VuePassportLogin },
  data () {
      return {
        apiUrl: 'http://survey.ok.dev/',
        secret: 'jcVLhbgtLtW7vBBezmyMyUHP9WoxUiEIfPpFjm1J',
        clientId: 2,
        hasError: false,
        error_msg: ''
      }
  },
  methods: {
    handleLogin (payload) {
      this.$store.commit('SET_USER', payload.authUser);
      this.$store.commit('SET_TOKEN', payload.authUser.access_token);
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