<template>
  <div>
    <el-breadcrumb separator="/">
      <el-breadcrumb-item :to="{ path: '/dashboard/survey' }">Homepage</el-breadcrumb-item>
      <el-breadcrumb-item>Result</el-breadcrumb-item>
      <!-- <el-breadcrumb-item>promotion list</el-breadcrumb-item>
      <el-breadcrumb-item>promotion detail</el-breadcrumb-item> -->
    </el-breadcrumb>
    <h1>Survey Result</h1>
    <div v-if="survey.length < 1">
      <div class="alert alert-purple alert-dismissable">
        <span class="glyphicon glyphicon-warning-sign"></span>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <strong>Warning!</strong> There are no questions in this survey!
      </div>
    </div>
    <div class="col-md-6 col-sm-6 col-lg-6" v-for="question in survey">
      <div class="panel panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title">{{question.title}}</h3>
        </div>
        <div class="panel-body">
          <div v-if="question.question_type == 'radio' || question.question_type == 'checkbox'">
            <div class="col-md-8 col-lg-8 col-sm-12">
              <div class="small">
                <pie-chart :chart-data="question.chart"></pie-chart>
              </div>
            </div>
            <div class="col-md-4 col-lg-4 col-sm-12">
              <span>Total Answers:</span><span>{{ question.total_answers }}</span>
              <div v-for="option in question.options" v-if="question.options.length > 0">
                <!-- {{question[option.title]}} -->
              </div>
            </div>
          </div>
          <div v-else>
            Question is Text type
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>

    import mixin from '../../mixins/general';
    import PieChart from '../../charts/PieChart';
    import {Bar} from 'vue-chartjs';

    export default {
      mixins: [mixin],
      components: {
        PieChart
      },
      mounted() {
       console.log(this.$route.params.survey);

       let Headerset = new Promise((resolve, reject) => {
           this.header = this.getHeaders(this.$store.state.user.access_token);
           if (this.header) {
               resolve(this.header);
           } else {
               reject('Rejected');
           }
       });
       this.fillData();
       Headerset.then((comeback) => {
         // console.log(`ComeBack!!!!!!!! ${comeback}`);
           this.getSurvey(this.$route.params.survey);
       }).catch((message) => {
           console.log(message); 
       });
     },
      data() {
        return {
          alreadyTakeBox: false,
          survey: {},
          datacollection: null,
        }
      },
      methods: {
        onSubmit() {
          let headers = this.header;
          axios.post('api/survey/take',this.survey.questions,{ headers }).then(response => {
            console.log(response);
            // this.$router.push('/dashboard/survey');

          }).catch(error => {
            console.log(error);
            if(error.response.status == 422){
              this.errors = error.response.data.errors;
            }
          })
        },
        onCancel() {

        },
        getSurvey(id){
            let headers = this.header;
            axios.get('api/survey/result/'+id ,{ headers }).then(response => {
                console.log(response);
                this.survey = response.data;
                
            }).catch(error => {
              console.log(error);
              if(error.response.status == 422){
              }
            })
        },

        // Chart Methods
        fillData () {
          this.datacollection = {
            labels: [this.getRandomInt(), this.getRandomInt()],
            datasets: [
              {
                label: 'Data One',
                backgroundColor: '#f87979',
                data: [this.getRandomInt(), this.getRandomInt()]
              }
            ]
          }
        },
        getRandomInt () {
          return Math.floor(Math.random() * (50 - 5 + 1)) + 5
        }
      }
    }
</script>

<style type="text/css">
  .danger{
    color: red;
  }
  .small {
    max-width: 300px;
    margin:  20px auto;
  }.alert-purple { border-color: #694D9F;background: #694D9F;color: #fff; }
</style>