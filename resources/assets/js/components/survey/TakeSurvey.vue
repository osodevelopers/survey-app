<template>
  <div>
    <div v-if="surveyBox">
      <div class="panel panel-primary">
        <div class="panel-heading">
          <h3>{{survey.title}}</h3>
          <h5>{{survey.description}}</h5>
        </div>
        <div class="panel-body">
          <div v-for="question in survey.questions" :key="question.title" v-if="survey.questions.length > 0">
            <h3><i class="el-icon-question">&nbsp;</i>Question :{{question.title}}</h3>
            <div v-if="question.question_type == 'checkbox'">
              <el-checkbox-group v-model="question.answer">
                  <el-checkbox v-for="(option,index) in question.options" :key="option.title" :name="option.title" :label="option.title"></el-checkbox>
              </el-checkbox-group>
            </div>
            <div v-if="question.question_type == 'radio'">
              <el-radio-group v-model="question.answer">
                  <el-radio v-for="(option,index) in question.options" :key="option.title" :label="option.title">{{option.title}}</el-radio><br/>
              </el-radio-group>
            </div>
            <div v-if="question.question_type == 'text'">
              <!-- <el-form-item label="Activity form"> -->
              <el-input type="textarea" v-model="question.answer"></el-input>
            <!-- </el-form-item> -->
            </div>
            <br/>  
          </div>
          <div v-if="survey.questions.length > 0">
            <br />
            <el-button type="primary" @click="onSubmit">Submit</el-button>
          </div>
          <div v-if="survey.questions.length <= 0">
            <div class="alert alert-purple alert-dismissable">
              <span class="glyphicon glyphicon-warning-sign"></span>
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              <strong>Warning!</strong> There are no Questions in this survey!
            </div>
          </div>
        </div>
      </div>
      <br/>
    </div>
    <div v-if="thankyouBox">
      <div class="alert alert-success-alt alert-dismissable">
        <span class="glyphicon glyphicon-thumbs-up"></span>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <strong>Well done!</strong> Thank You For taking that Survey!
      </div>
    </div>
    <div v-if="alreadyTakeBox">
      <div class="alert alert-purple alert-dismissable">
        <span class="glyphicon glyphicon-warning-sign"></span>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <strong>Warning!</strong> You have alredy Take this Survey!
      </div>
    </div>
  </div>
</template>
<script>
    import mixin from '../../mixins/general';
    export default {
     mixins: [mixin],
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
       Headerset.then((comeback) => {
         // console.log(`ComeBack!!!!!!!! ${comeback}`);
           this.getSurvey(this.$route.params.survey);
       }).catch((message) => {
           console.log(message); 
       });
     },
      data() {
        return {
          form: {
            survey_id: Number(this.$route.params.survey),
            title: '',
            active: true,
            anonymous: false,
            description: ''
          },
          survey:{},
          header: {},
          errors: [],
          selectedOption: [],
          radio2: '',
          surveyBox: false,
          thankyouBox: false,
          alreadyTakeBox: false
        }
      },
      methods: {
        onSubmit() {
          let headers = this.header;
          axios.post('api/survey/take',this.survey.questions,{ headers }).then(response => {
            console.log(response);
            this.surveyBox = false;
            this.thankyouBox = true;
            // this.$router.push('/dashboard/survey');

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
        getSurvey(id){
            let headers = this.header;
            axios.get('api/survey/'+id ,{ headers }).then(response => {
                console.log(response);
                this.surveyBox = true;
                this.survey = response.data;
            }).catch(error => {
              console.log(error);
              if(error.response.status == 422){
                this.alreadyTakeBox = true;
              }
            })
        }
      }
    }
</script>

<style type="text/css">
  .danger{
    color: red;
  }.alert-purple { border-color: #694D9F;background: #694D9F;color: #fff; }
  .alert-success-alt { border-color: #19B99A;background: #20A286;color: #fff; }
.glyphicon { margin-right:10px; }
</style>