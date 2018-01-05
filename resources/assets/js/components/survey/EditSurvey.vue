<template>
    <div>
        <el-breadcrumb separator="/">
          <el-breadcrumb-item :to="{ path: '/dashboard/survey' }">Homepage</el-breadcrumb-item>
          <el-breadcrumb-item>Surveys</el-breadcrumb-item>
          <el-breadcrumb-item>Edit Survey</el-breadcrumb-item>
          <!-- <el-breadcrumb-item>promotion list</el-breadcrumb-item>
          <el-breadcrumb-item>promotion detail</el-breadcrumb-item> -->
        </el-breadcrumb>
        <br>
        <div class="panel panel-primary">
          <div class="panel-heading">
            <h3 class="panel-title">Update Survey</h3>
          </div>
          <div class="panel-body">
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
                    <el-button type="primary" @click="onSubmit">Update</el-button>
                    <el-button @click="onCancel">Cancel</el-button>
                </el-form-item>
            </el-form>
          </div>
        </div>
    </div>
</template>
<script>
    import mixin from '../../mixins/general';
    export default {
      mixins: [mixin],
     mounted() {
        let Headerset = new Promise((resolve, reject) => {
              this.header = this.getHeaders(this.$store.state.user.access_token);
              if (this.header) {
                  resolve(this.header);
              } else {
                  reject('I will always love you');
              }
          });
          Headerset.then((comeback) => {
            console.log(`ComeBack!!!!!!!! ${comeback}`);
              this.getSurvey(this.$route.params.id);
          }).catch((message) => {
              console.log(message); 
          });
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
          console.log('submit!');
          let headers = this.header;
          axios.post('api/survey/update/'+this.$route.params.id,this.form,{ headers }).then(response => {
            console.log(response);
            this.$router.push('/dashboard/survey');
          }).catch(error => {
            console.log(error.response);
            if(error.response.status == 422){
              this.errors = error.response.data.errors;
            }
          })
        },
        onCancel() {
            this.testMixin();
        },
        getSurvey(id){
            let headers = this.header;
            axios.get('api/survey/edit/'+id ,{ headers }).then(response => {
                console.log(response);
                this.form.title = response.data.title;
                this.form.active = Boolean(response.data.active);
                this.form.anonymous = Boolean(response.data.anonymous);
                this.form.description = response.data.description;
            })
        }
      }
    }
</script>
<style type="text/css">
  .danger{
    color: red;
  }
</style>