<template>
<div>
<h1>User's Surveys</h1>
<br>
  <el-row :gutter="10">
    <el-col :xs="24" :sm="12" :md="6" :lg="6" :xl="6" v-for="(survey,index) in surveys" :key="survey.id">
      <div class="grid-content bg-purple">
        <div class="delete-button">
          <el-tooltip class="item" effect="dark" content="Delete Survey" placement="top">
            <el-button size="mini" type="danger" @click="deleteSurvey(survey.id)" icon="el-icon-delete"></el-button>
          </el-tooltip>
        </div>
        <div class="title" @click="editSurvey(survey.id)">
          {{survey.title}}
        </div>
        <div class="center" style="padding-bottom: 10px;">
          <span>Anonymous: <el-switch v-model="surveys[index].anonymous"></el-switch></span>
        </div>
        <div class="center" style="padding-bottom: 10px;">
          <span>Active: <el-switch v-model="surveys[index].active"></el-switch></span>
        </div>
        <div class="center" style="padding-bottom: 35px;">
          <el-button type="primary" icon="el-icon-plus" size="mini" @click="createQuestion(survey.id)">Add Question</el-button>
        </div>
        <div class="center">
          <el-button-group>
            <el-tooltip class="item" effect="dark" content="Edit" placement="top">
              <el-button type="primary" icon="el-icon-edit" @click="editSurvey(survey.id)"></el-button>
            </el-tooltip>
            <el-tooltip class="item" effect="dark" content="Share" placement="top">
              <el-button type="primary" icon="el-icon-share"></el-button>
            </el-tooltip>
            <el-tooltip class="item" effect="dark" content="Results" placement="top">
              <el-button type="primary" icon="el-icon-tickets"></el-button>
            </el-tooltip>
          </el-button-group>
        </div>
      </div>
    </el-col>
  </el-row>
  <br>
  <!-- <v-client-table :data="tableData" :columns="columns" :options="options"></v-client-table> -->
</div>
</template>
<script>
  export default {
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
          this.getSurveys();
      }).catch((message) => {
          console.log(message); 
      });
      
    },
    data() {
      return {
        loading: false,
        header : {},
        surveys: [],
      }
    },
    methods: {
      onSubmit() {
        console.log('submit!');
      },
      getSurveys(){
        let headers = this.header;
        axios.get('api/survey/list',{ headers }).then(response => {
          console.log(response);
          this.surveys = response.data;
        });
      },
      getHeaders(token) {
        return {
          Accept: 'application/json',
          Authorization: `Bearer ${token}`
        }
      },
      createQuestion(survey) {
        this.$router.push({ name: 'create-question', params: { survey }});
      },
      editSurvey(id){
        this.$router.push({ name: 'edit-survey', params: { id }});
      },
      deleteSurvey(id){
        var delete_id = id;
        this.$confirm('This will permanently delete the file. Continue?', 'Warning', {
          confirmButtonText: 'OK',
          cancelButtonText: 'Cancel',
          type: 'warning'
        }).then(() => {
          let headers = this.header;
          axios.delete('api/survey/delete/'+delete_id,{ headers }).then(response => {
            console.log(response);
            this.getSurveys();
            this.$message({
              type: 'success',
              message: 'Delete completed'
            });
          }).catch(error => {
            console.log(error);
          })
        }).catch(() => {
          this.$message({
            type: 'info',
            message: 'Delete canceled'
          });          
        });
      }
    }
  }
</script>

<style>
  .title{
    text-align: center;
    font-size: 18px;
    font-weight: 700;
    padding-top: 5px;
    cursor: pointer;
    /*text-*/
  }
  .center{
    text-align: center;
  }
  .el-row {
    margin-bottom: 10px;
  }
  .el-col {
    border-radius: 4px;
  }
  .bg-purple-dark {
    background: #99a9bf;
  }
  .bg-purple {
    background: #d3dce6;
  }
  .bg-purple-light {
    background: #e5e9f2;
  }
  .grid-content {
    border-radius: 4px;
    min-height: 36px;
    margin-bottom: 36px;
  }
</style>