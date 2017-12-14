<template>
    <div>
        <h1>Create Survey</h1>
        <br>
        <el-form ref="form" :model="form" label-width="120px">
            <el-form-item label="Survey Name" required>
                <el-input v-model="form.title"></el-input>
                <span class="danger" v-if="errors['title']">{{errors['title'][0]}}</span>
            </el-form-item>
            <el-form-item label="Description">
                <el-input type="textarea" v-model="form.description"></el-input>
            </el-form-item>
            <el-form-item label="Active">
                <el-switch v-model="form.active"></el-switch>
            </el-form-item>
            <el-form-item label="Anonymous">
                <el-switch v-model="form.anonymous"></el-switch>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" @click="onSubmit">Create</el-button>
                <el-button @click="onCancel">Cancel</el-button>
            </el-form-item>
        </el-form>
    </div>
</template>
<script>
    export default {
     mounted() {
        this.header = this.getHeaders(this.$store.state.user.access_token);
     },
      data() {
        return {
          form: {
            title: '',
            active: true,
            anonymous: false,
            description: ''
          },
          header: {},
          errors: []
        }
      },
      methods: {
        onSubmit() {
          let headers = this.header;
          axios.post('api/survey/create',this.form,{ headers }).then(response => {
            this.$router.push('/dashboard/survey');
          }).catch(error => {
            console.log(error);
            if(error.response.status == 422){
              this.errors = error.response.data.errors;
            }
          })
        },
        onCancel() {
            // let headers = this.header;
            // axios.get('api/user',{ headers }).then(response => {
            //     console.log(response);
            // })
        },
        getHeaders(token) {
            return {
                Accept: 'application/json',
                Authorization: `Bearer ${token}`
            }
        }
      }
    }
</script>

<style type="text/css">
  .danger{
    color: red;
  }
</style>