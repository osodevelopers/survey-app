<template>
  <div>
    <div v-if="surveyBox">
      <div class="panel panel-primary">
        <div class="panel-heading">
          <h3>{{survey.title}}</h3>
          <h5>{{survey.description}}</h5>
        </div>
        <div class="panel-body">
          <div v-for="(question,qindex) in survey.questions" :key="question.title">
            <div class="row">
              <div class="col-md-12 col-lg-12 col-xs-12">
                <el-button-group>
                  <el-tooltip class="item" effect="dark" content="Edit" placement="top">
                    <el-button type="primary" size="mini" icon="el-icon-edit" @click="editQuestion(qindex)"></el-button>
                  </el-tooltip>
                  <el-tooltip class="item" effect="dark" content="Delete Question" placement="top">
                    <el-button size="mini" type="danger" @click="deleteQuestion(question.id)" icon="el-icon-delete"></el-button>
                  </el-tooltip>
                </el-button-group>
              </div>
            </div>
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
        </div>
      </div>
      <br/>
    </div>
    <!-- Modal for Edit Form -->
    <el-dialog title="Edit Question" :visible.sync="dialogFormVisible">
      <el-form ref="form" :model="form" label-width="120px">
        <el-form-item label="Question Title">
            <el-input type="textarea" v-model="form.title"></el-input>
        </el-form-item>
        <el-form-item label="Required">
            <el-switch v-model="form.require"></el-switch>
        </el-form-item>
        <el-form-item label="Question Type">
            <el-select v-model="form.question_type" placeholder="please select question type">
                <el-option label="Checkbox" value="checkbox"></el-option>
                <el-option label="Radio" value="radio"></el-option>
                <el-option label="Text" value="text"></el-option>
            </el-select>
        </el-form-item>
        <div v-if="form.question_type == 'radio' || form.question_type == 'checkbox'">
            <el-form-item label="Option">
                <el-input type="text" v-model="tempOption.title" @keyup.enter.native="addOption"></el-input>
            </el-form-item>
            <el-form-item label="Options" v-show="form.options.length > 0">
                <el-input style="padding-bottom: 10px;" v-for="(option,index) in form.options" :key="index" type="text" v-model="form.options[index].title">
                  <el-button slot="append" icon="el-icon-delete" title="Delete" @click.native="removeOption(option)"></el-button>
                </el-input>
            </el-form-item>
        </div>
        <!-- <el-form-item>
          <el-button type="primary" @click="onSubmit">Create</el-button>
        </el-form-item> -->
    </el-form>
      <span slot="footer" class="dialog-footer">
        <el-button @click="dialogFormVisible = false">Cancel</el-button>
        <el-button type="primary" @click="onSubmit(form.id)">Submit</el-button>
      </span>
    </el-dialog>
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
          form: {},
          dialogFormVisible: false,
          survey:{},
          header: {},
          errors: [],
          selectedOption: [],
          tempOption: {'title' : ''},
          radio2: '',
          surveyBox: false,
          thankyouBox: false,
          alreadyTakeBox: false
        }
      },
      methods: {
        onSubmit(id) {
          let headers = this.header;
          this.dialogFormVisible = false;
          axios.post('api/question/update/'+id,{'data': this.form},{headers}).then(response => {
            console.log(response);
            // this.$router.push('/dashboard/survey');

          }).catch(error => {
            console.log(error);
            if(error.response.status == 422){
              this.errors = error.response.data.errors;
            }
          })
        },
        getSurvey(id){
            let headers = this.header;
            axios.get('api/survey/questions/'+id ,{ headers }).then(response => {
                console.log(response);
                this.surveyBox = true;
                this.survey = response.data;
                this.$store.dispatch('setSurvey',response.data);
            }).catch(error => {
              console.log(error);
            })
        },
        addOption(){
          if(this.tempOption){
            this.form.options.push(this.tempOption);
            this.tempOption = {'title' : ''};
          }
        },
        removeOption(name) {
          this.form.options.splice(this.form.options.indexOf(name), 1);
        },
        editQuestion(id){
          this.form = this.survey.questions[id];
          this.dialogFormVisible = true;
        },
        deleteQuestion(id){
          var delete_id = id;
          this.$confirm('This will permanently delete the file. Continue?', 'Warning', {
            confirmButtonText: 'OK',
            cancelButtonText: 'Cancel',
            type: 'warning'
          }).then(() => {
            let headers = this.header;
            axios.delete('api/question/delete/'+delete_id,{ headers }).then(response => {
              console.log(response);
              this.getSurvey(this.$route.params.survey);
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

<style type="text/css">
  .danger{
    color: red;
  }.alert-purple { border-color: #694D9F;background: #694D9F;color: #fff; }
  .alert-success-alt { border-color: #19B99A;background: #20A286;color: #fff; }
.glyphicon { margin-right:10px; }
</style>