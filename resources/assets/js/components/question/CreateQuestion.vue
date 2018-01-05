<template>
    <div>
        <h1>Add Question</h1>
        <br>
        <el-row :gutter="35">
            <!-- Form Section -->
            <el-col :span="12">
              <div class="panel panel-primary">
                <div class="panel-heading">
                  <h3 class="panel-title">Add Question</h3>
                </div>
                <div class="panel-body">
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
                              <el-input type="text" v-model="tempOption" @keyup.enter.native="addOption"></el-input>
                          </el-form-item>
                          <el-form-item label="Options" v-show="form.options.length > 0">
                              <el-input style="padding-bottom: 10px;" v-for="(option,index) in form.options" :key="index" type="text" v-model="form.options[index]">
                                  <el-button slot="append" icon="el-icon-delete" title="Delete" @click.native="removeOption(option)"></el-button>
                              </el-input>
                          </el-form-item>
                      </div>
                      <el-form-item>
                          <el-button type="primary" @click="onSubmit">Create</el-button>
                          <el-button>Cancel</el-button>
                      </el-form-item>
                  </el-form>
                </div>
              </div>
            </el-col>
            <!-- Preview Section -->
            <el-col :span="12">
              <div class="panel panel-primary">
                <div class="panel-heading">
                  <h3 class="panel-title">Preview</h3>
                </div>
                <div class="panel-body">
                  <div class="grid-content">
                    <!-- <span><i class="fa fa-trash"></i>He</span> -->
                    <div>
                      <div class="pull-left"><h3 v-html="form.title"></h3></div>
                      <div class="pull-left" v-if="form.require"><span class="danger">*</span></div>
                    </div>
                    
                    <!-- <span class="danger" v-if="form.require">required*</span> -->
                    <!-- if Type id Checkbox -->
                    <div v-if="form.question_type == 'checkbox'">
                        <el-checkbox-group v-model="selectedOption">
                            <el-checkbox v-for="(option,index) in form.options" :key="option" :name="option" :label="option"></el-checkbox>
                        </el-checkbox-group>
                    </div>
                    <!-- if Type is Radio -->
                    <div v-if="form.question_type == 'radio'">
                        <el-radio-group v-model="radio2">
                            <el-radio v-for="(option,index) in form.options" :key="option" :label="option">{{option}}</el-radio><br/>
                        </el-radio-group>
                    </div>
                </div>
                </div>
              </div>
                
            </el-col>
        </el-row>
    </div>
</template>
<script>
    import mixin from '../../mixins/general';
    export default {
      mixins: [mixin],
      mounted(){
        console.log(this.$route.params.survey);
        this.header = this.getHeaders(this.$store.state.user.access_token);
      },
      data() {
        return {
          form: {
           options:[],
           survey_id: Number(this.$route.params.survey),
           require: false,
          },
          header:{},
          tempOption: '',
          // options: ['Sample','Option1','Option2','Option3'],
          selectedOption: [],radio2:''
        }
      },
      methods: {
        onSubmit() {
          let headers = this.header;
            axios.post('api/question/create',this.form,{ headers }).then(response => {
              console.log(response);
              this.$router.push('/dashboard/survey');
            }).catch(error => {
              console.log(error);
              if(error.response.status == 422){
                this.errors = error.response.data.errors;
              }
            })
        },
        addOption(){
            if(this.tempOption){
                this.form.options.push(this.tempOption);
                this.tempOption = '';
            }
        },
        removeOption(name) {
            this.form.options.splice(this.form.options.indexOf(name), 1);
        }
      }
    }
</script>
<style type="text/css">
    .bg-purple {
        background: #d3dce6;
    }
</style>