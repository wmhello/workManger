<template>
  <div>
    <el-form :model="form" :rules="rules" ref="form" label-width="100px" class="demo-form">

      <el-form-item label="角色名称" prop="name">
        <el-input v-model="form.name"></el-input>
      </el-form-item>
      <el-form-item label="角色说明" prop="explain">
        <el-input v-model="form.explain"></el-input>
      </el-form-item>
      <el-form-item label="角色备注" prop="remark">
        <el-input v-model="form.remark"></el-input>
      </el-form-item>

      <el-form-item>
        <el-button type="primary" @click="submitForm('form')">立即创建</el-button>
        <el-button @click="resetForm('form')">重置</el-button>
      </el-form-item>

    </el-form>
  </div>
</template>

<script>
import { getToken } from "@/utils/auth";
import { addNewRole } from "@/api/role";
import roleConfig from "./../../../static/config";

function Role(name='', explain = '', remark = '')  {
  this.name = name
  this.explain = explain
  this.remark = remark
}

export default {
  data(){
    return{
      form: new Role(),
      rules: {
        name: [
          { required: true, message: '请填写角色名', trigger: 'blur' }
        ],
        explain: [
          { required: true, message: '请填写角色说明', trigger: 'blur' }
        ],
        remark: [
          { message: '请填写角色备注', trigger: 'blur' }
        ]
      }
    }
  },
  methods:{
    submitForm (formName) {
      this.$refs[formName].validate((valid) => {
        if (valid) {
          addNewRole(this.form).then(response => {
              this.$alert('新角色建立成功','友情提示', {
                callback: action => {
                   // 清空内容，重新开始建立
                   let administrator = new Role()
                   this.form = administrator
                }
              })
          }).catch(error => {
              console.log(error.response)
          })
        } else {
          this.$message.error('数据校验不通过，请重新填写')
          return false;
        }
      });
    },
    resetForm (formName) {
      this.$refs[formName].resetFields();
    },
  },
  mounted () {

  },
  created() {

  }
}
</script>

<style>

</style>
