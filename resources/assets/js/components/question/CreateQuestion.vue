<template>
    <div>
        <h1>Add Question</h1>
        <br>
        <el-row :gutter="35">
            <!-- Form Section -->
            <el-col :span="12">
                <el-form ref="form" :model="form" label-width="120px">
                    <el-form-item label="Question Title">
                        <el-input type="textarea" v-model="form.title"></el-input>
                    </el-form-item>
                    <el-form-item label="Required">
                        <el-switch v-model="form.required"></el-switch>
                    </el-form-item>
                    <el-form-item label="Question Type">
                        <el-select v-model="form.question_type" placeholder="please select question type">
                            <el-option label="Checkbox" value="checkbox"></el-option>
                            <el-option label="Radio" value="radio"></el-option>
                        </el-select>
                    </el-form-item>

                    <el-form-item label="Option">
                        <el-input type="text" v-model="tempOption" @keyup.enter.native="addOption"></el-input>
                    </el-form-item>
                    <el-form-item label="Options" v-show="options.length > 0">
                        <el-input style="padding-bottom: 10px;" v-for="(option,index) in options" :key="index" type="text" v-model="options[index]">
                            <el-button slot="append" icon="el-icon-delete" title="Delete" @click.native="removeOption(option)"></el-button>
                        </el-input>
                    </el-form-item>
                    <el-form-item>
                        <el-button type="primary" @click="onSubmit">Create</el-button>
                        <el-button>Cancel</el-button>
                    </el-form-item>
                </el-form>
            </el-col>
            <!-- Preview Section -->
            <el-col :span="12">
                <div class="grid-content bg-purple">
                    <h2 v-html="form.title"></h2>
                    <!-- if Type id Checkbox -->
                    <div v-if="form.question_type == 'checkbox'">
                        <el-checkbox-group v-model="selectedOption">
                            <el-checkbox v-for="(option,index) in options" :key="option" :name="option" :label="option"></el-checkbox>
                        </el-checkbox-group>
                    </div>
                    <!-- if Type is Radio -->
                    <div v-if="form.question_type == 'radio'">
                        <el-radio-group v-model="radio2">
                            <el-radio v-for="(option,index) in options" :key="option" :label="option">{{option}}</el-radio>
                        </el-radio-group>
                    </div>
                </div>
            </el-col>
        </el-row>
    </div>
</template>
<script>
    export default {
      mounted(){
        console.log(this.$route.params.survey);
      },
      data() {
        return {
          form: {
           
          },
          tempOption: '',
          options: ['Sample','Option1','Option2','Option3'],
          selectedOption: [],radio2:''
        }
      },
      methods: {
        onSubmit() {
          console.log('submit!');
        },
        addOption(){
            if(this.tempOption){
                this.options.push(this.tempOption);
                this.tempOption = '';
            }
        },
        removeOption(name) {
            this.options.splice(this.options.indexOf(name), 1);
        }
      }
    }
</script>
<style type="text/css">
    .bg-purple {
        background: #d3dce6;
    }
</style>