<template>
  <div>

    <!-- 角色列表 -->
    <el-table :data="tableData" border style="width: 100%">
      <el-table-column prop="id" label="序号" width="70">
      </el-table-column>
      <el-table-column prop="name" label="角色" width="180">
      </el-table-column>
      <el-table-column prop="explain" label="描述" width="200">
      </el-table-column>
      <el-table-column prop="remark" label="备注" width="500">
      </el-table-column>
      <el-table-column label="操作">
        <template scope="scope">
          <el-tooltip content="编辑" placement="top">
            <el-button plain icon="edit" type="info" size="small" @click="edit(scope.row)"></el-button>
          </el-tooltip>
          <el-tooltip content="删除" placement="top">
            <el-button plain icon="delete" type="danger" size="small" @click="del(scope.row)"></el-button>
          </el-tooltip>
        </template>
      </el-table-column>
    </el-table>

    <!-- 修改角色信息 -->
    <el-dialog title="修改角色信息" :visible.sync="dialogVisible" size="tiny">
      <el-form :model="form" label-width="80px">
        <el-form-item label="角色">
          <el-input v-model="form.name" placeholder=''></el-input>
        </el-form-item>
        <el-form-item label="描述">
           <el-input v-model="form.explain" placeholder=''></el-input>
        </el-form-item>
        <el-form-item label="备注">
          <el-input v-model="form.remark"></el-input>
        </el-form-item>
      </el-form>
      <span slot="footer" class="dialog-footer">
        <el-button @click="dialogVisible = false">取 消</el-button>
        <el-button type="primary" @click="saveData()">确 定</el-button>
      </span>
    </el-dialog>

  </div>
 </template>

<script>
import { getToken } from "@/utils/auth";
import {
  getRole,
  getRoleById,
  updataRoleInfo,
  deleteRoleById
} from "@/api/role";

import roleConfig from "./../../../static/config";

export default {
  data(){
    return{
      tableData: [],
      dialogVisible: false,
      uploadId: "",
      form: {
        id: "",
        name: "",
        explain: "",
        remark: ""
      },
    }
  },
  methods:{
    fetchData() {
      getRole()
        .then(response => {
          //成功执行内容
          let result = response.data;
          this.tableData = result;
        })
        .catch(() => {
          //失败执行内容
        });
    },
    edit(row) {
      let id = row.id;
      this.uploadId = id;
      getRoleById(id).then(response => {
        let result = response.data;
        this.form = result;
        this.dialogVisible = true;
      });
    },
    saveData() {
      updataRoleInfo(this.uploadId, this.form)
        .then(response => {
          //成功执行内容
          let result = response.status_code;
          if (result == 200) {
            let currentId = this.form.id;
            let record = 0;
            record = this.tableData.findIndex((val, index) => {
              return val.id == currentId;
            });
            this.tableData.splice(record, 1, this.form);
            this.dialogVisible = false;
          }
        })
        .catch(() => {
          //失败执行内容
        });
    },
    del(row) {
      this.$confirm("此操作将永久删除该权限, 是否继续?", "提示", {
        confirmButtonText: "确定",
        cancelButtonText: "取消",
        type: "warning"
      })
        .then(() => {
          let id = row.id;
          let record = null;
          record = this.tableData.findIndex(val => val.id == id);

          deleteRoleById(id)
            .then(response => {
              let result = response.status_code;
              if (result == 200) {
                this.$message({
                  type: "success",
                  message: "删除成功!"
                });
                this.tableData.splice(record, 1);
              }
            })
            .catch(() => {
              //失败执行内容
            });
        })
        .catch(() => {});
    },
  },
  mounted(){
    this.fetchData()
  },
  created(){

  }
}
</script>

<style>
 .el-form-item__label{
   text-align: center;
 }
</style>
