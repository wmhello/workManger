<template>
  <div>
    <el-button type="primary" plain size="large" icon="el-icon-document" @click="add()">添加</el-button>
    <div style="margin-bottom: 10px;"></div>

    <!-- 班主任列表 -->
    <el-table :data="tableData" border style="width: 100%">
      <el-table-column prop="id" label="序号" width="70">
      </el-table-column>
      <el-table-column prop="session_id" label="学期ID" width="120">
      </el-table-column>
      <el-table-column prop="teacher_id" label="教师ID" width="120">
      </el-table-column>
      <el-table-column prop="class" label="班级" width="120">
      </el-table-column>
      <el-table-column prop="grade" label="年级" width="120">
      </el-table-column>
      <el-table-column prop="remark" label="备注" width="300">
      </el-table-column>
      <el-table-column label="操作">
        <template slot-scope="scope">
          <el-tooltip content="编辑" placement="top">
            <el-button plain icon="el-icon-edit" type="info" size="small" @click="edit(scope.row)"></el-button>
          </el-tooltip>
          <el-tooltip content="删除" placement="top">
            <el-button plain icon="el-icon-delete" type="danger" size="small" @click="del(scope.row)"></el-button>
          </el-tooltip>
        </template>
      </el-table-column>
    </el-table>

    <!-- 编辑列表 -->
    <el-dialog title="班主任信息" :visible.sync="editDialogFormVisible" :close-on-click-modal="false">
      <el-form :model="form" label-width="100px">
        <el-form-item label="学期ID"  prop="session_id">
          <el-input v-model="form.session_id" placeholder="请填写学期ID" required>
          </el-input>
        </el-form-item>

        <el-form-item label="教师ID"  prop="teacher_id">
          <el-input v-model="form.teacher_id" placeholder="请填写教师ID" required>
          </el-input>
        </el-form-item>

        <el-form-item label="班级"  prop="class">
          <el-input v-model="form.class" placeholder="请填写班级" required>
          </el-input>
        </el-form-item>

        <el-form-item label="年级" prop="grade">
          <el-select v-model="form.grade" placeholder="请选择年级" required>
            <el-option label="一年级" :value="1">一年级</el-option>
            <el-option label="二年级" :value="2">二年级</el-option>
            <el-option label="三年级" :value="3">三年级</el-option>
          </el-select>
        </el-form-item>

        <el-form-item label="备注" prop="remark">
          <el-input v-model="form.remark" :value="3"></el-input>
        </el-form-item>
      </el-form>

      <div slot="footer" class="dialog-footer">
        <el-button @click="editDialogFormVisible = false">取 消</el-button>
        <el-button type="primary" @click="saveData()">确 定</el-button>
      </div>
    </el-dialog>

    <!-- 新增列表 -->
    <el-dialog title="班主任信息" :visible.sync="addDialogFormVisible" :close-on-click-modal="false">
      <el-form :model="newform" label-width="100px">
        <el-form-item label="学期ID"  prop="session_id">
          <el-input v-model="newform.session_id" placeholder="请填写学期ID" required>
          </el-input>
        </el-form-item>

        <el-form-item label="教师ID"  prop="teacher_id">
          <el-input v-model="newform.teacher_id" placeholder="请填写教师ID" required>
          </el-input>
        </el-form-item>

        <el-form-item label="班级" prop="class">
          <el-input v-model="newform.class" placeholder="请填写班级" required>
          </el-input>
        </el-form-item>

        <el-form-item label="年级" prop="grade">
          <el-select v-model="newform.grade" placeholder="请选择年级" required>
            <el-option label="一年级" :value="1">一年级</el-option>
            <el-option label="二年级" :value="2">二年级</el-option>
            <el-option label="三年级" :value="3">三年级</el-option>
          </el-select>
        </el-form-item>

        <el-form-item label="备注"  prop="remark">
          <el-input v-model="newform.remark"></el-input>
        </el-form-item>

        <el-form-item>
          <el-button type="primary" @click="submitForm('newform')">立即创建</el-button>
          <el-button @click="resetForm('newform')">重置</el-button>
        </el-form-item>
      </el-form>
    </el-dialog>

    <!-- 分页 -->
    <el-pagination
      background
      @current-change="handleCurrentChange"
      :current-page.sync="current_page"
      layout="total, prev, pager, next"
      :page-size="15"
      :total="total">
    </el-pagination>

  </div>
</template>

<script>
  import { getToken } from "@/utils/auth";
  import {
    getClassTeacher,
    getClassTeacherById,
    addNewClassTeacher,
    updateClassTeacherInfo,
    deleteClassTeacherById
 } from "@/api/classTeacher";

import ClassTeacherConfig from "./../../../static/config";

function ClassTeacher (session_id = null, teacher_id = null, leader_type = null, grade = null, remark = null) {
  this.session_id = session_id
  this.teacher_id = teacher_id
  this.leader_type = leader_type
  this.grade = grade
  this.remark = remark
}

export default {
  data(){
    return{
      tableData: [],
      dialogFormVisible: false,
      resetDialogFormVisible: false,
      editDialogFormVisible: false,
      addDialogFormVisible: false,
      resetId: "",
      uploadId: "",
      form: {
        id: "",
        session_id: 0,
        teacher_id: 0,
        class: "",
        grade: "",
        remark: ""
      },
      newform: new ClassTeacher(),
      current_page: 1,
      total: 0
    }
  },
  methods:{
    fetchData() {
      getClassTeacher()
        .then(response => {
          //成功执行内容
          let result = response.data;
          // console.log(result);
          this.tableData = result;
          this.total = response.meta.total;
        })
        .catch(() => {
          //失败执行内容
        });
    },
    add () {
      this.addDialogFormVisible = true;
    },
    edit (row) {
      let id = row.id;
      this.uploadId = id;
      getClassTeacherById(id).then(response => {
        let result = response.data;
        this.form = result;
        /*
        this.form.gradeBig =  this.form.grade == '1'?'一':
                              this.form.grade == '2'?'二':'三';
        this.form.remark = `高${this.form.gradeBig}（${this.form.class}）班`;
        */
        this.editDialogFormVisible = true;
      });
    },
    saveData () {
      updateClassTeacherInfo(this.uploadId, this.form).then(response => {
        //成功执行内容
        let result = response.status_code;
        // console.log(result);
        if (result == 200) {
          let currentId = this.form.id;
          let record = 0;
          record = this.tableData.findIndex((val, index) => {
            return val.id == currentId;
          });
          this.tableData.splice(record, 1, this.form);
          this.editDialogFormVisible = false;
        }
      })
      .catch(() => {
        //失败执行内容
        console.log('连接失败');
        // console.log(error.response);
      });
    },
    resetForm () {
      this.newform = new ClassTeacher();
      this.resetDialogFormVisible = true;

    },
    submitForm () {
      addNewClassTeacher(this.newform).then(response => {
        // console.log(response)
        this.$alert('新建成功', '友情提示', {
          callback: action => {
            // 清空内容，重新开始建立
            // this.newform = new Leader()
            this.addDialogFormVisible = false;
          }
        })
      }).catch(error => {
        console.log(error.response)
      })
    },
    del (row) {
      this.$confirm("此操作将永久删除该信息, 是否继续?", "提示", {
        confirmButtonText: "确定",
        cancelButtonText: "取消",
        type: "warning"
      })
        .then(() => {
          let id = row.id;
          let record = null;
          record = this.tableData.findIndex(val => val.id == id);

          deleteClassTeacherById(id).then(response => {
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
            console.log('删除失败');
          });
        })
        .catch(() => { });
    },
    handleCurrentChange(val){
      let current_page = val;
      this.current_page = current_page;
      //console.log(`当前页: ${val}`);
      getClassTeacher(current_page).then(response => {
        let result = response.data;
        this.tableData = result;
      })
    }
  },
  mounted(){
    this.fetchData()
  },
  created(){

  }
}
</script>

<style>
.el-pagination{
  padding: 0;
  margin-top: 20px;
  text-align: right;
}
</style>
