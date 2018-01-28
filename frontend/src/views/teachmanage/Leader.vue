<template>
  <div>
    <el-button type="primary" plain size="large" icon="el-icon-document" @click="add()">添加</el-button>

    <!-- 下拉搜索 -->
    <!-- <el-dropdown @command="handleCommand">
      <el-button type="primary">
        按行政查询<i class="el-icon-arrow-down el-icon--right"></i>
      </el-button>
      <el-dropdown-menu slot="dropdown">
        <el-dropdown-item command="学校">学校</el-dropdown-item>
        <el-dropdown-item command="中层">中层</el-dropdown-item>
        <el-dropdown-item command="全部">全部</el-dropdown-item>
      </el-dropdown-menu>
    </el-dropdown> -->

    <!-- <el-dropdown split-button type="primary" @command="handleCommand">
      按行政查询
      <el-dropdown-menu slot="dropdown">
        <el-dropdown-item command="学校">学校</el-dropdown-item>
        <el-dropdown-item command="中层">中层</el-dropdown-item>
        <el-dropdown-item command="全部">全部</el-dropdown-item>
      </el-dropdown-menu>
    </el-dropdown> -->

    <!-- <el-select v-model="value8"
      filterable
      remote
      placeholder="按行政查询">
      <el-option
        v-for="item in options"
        :key="item.value"
        :label="item.label"
        :value="item.value">
      </el-option>
    </el-select> -->

    <el-input placeholder="请输入ID" v-model="search_teacherID">
      <el-button slot="append" icon="el-icon-search" @click="searchTeacherID"></el-button>
    </el-input>

    <div style="margin-bottom: 10px;"></div>

    <!-- 学校行政列表 -->
    <el-table :data="tableData" border style="width: 100%">
      <el-table-column prop="id" label="序号" width="70">
      </el-table-column>
      <el-table-column prop="session_id" label="学期ID" width="120">
      </el-table-column>
      <el-table-column prop="teacher_id" label="教师ID" width="120">
      </el-table-column>
      <el-table-column prop="leader_type" label="行政类型" width="120">
      </el-table-column>
      <el-table-column prop="job" label="职务描述" width="180">
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
    <el-dialog title="行政信息" :visible.sync="editDialogFormVisible" :close-on-click-modal="false">
      <el-form :model="form" label-width="100px">
        <el-form-item label="学期ID"  prop="session_id">
          <el-input v-model="form.session_id" placeholder="请填写学期ID" required>
          </el-input>
        </el-form-item>

        <el-form-item label="教师ID"  prop="teacher_id">
          <el-input v-model="form.teacher_id" placeholder="请填写教师ID" required>
          </el-input>
        </el-form-item>

        <el-form-item label="行政类型" prop="leader_type">
          <el-select v-model="form.leader_type" placeholder="请选择行政类型">
            <el-option label="中层" :value="1">中层</el-option>
            <el-option label="学校" :value="2">学校</el-option>
          </el-select>
        </el-form-item>

        <el-form-item label="职务描述"  prop="job">
          <el-input v-model="form.job"></el-input>
        </el-form-item>

        <el-form-item label="备注"  prop="remark">
          <el-input v-model="form.remark"></el-input>
        </el-form-item>
      </el-form>

      <div slot="footer" class="dialog-footer">
        <el-button @click="editDialogFormVisible = false">取 消</el-button>
        <el-button type="primary" @click="saveData()">确 定</el-button>
      </div>
    </el-dialog>

    <!-- 新增列表 -->
    <el-dialog title="行政信息" :visible.sync="addDialogFormVisible" :close-on-click-modal="false">
      <el-form :model="newform" label-width="100px">
        <el-form-item label="学期ID"  prop="session_id">
          <el-input v-model="newform.session_id" placeholder="请填写学期ID" required>
          </el-input>
        </el-form-item>

        <el-form-item label="教师ID"  prop="teacher_id">
          <el-input v-model="newform.teacher_id" placeholder="请填写教师ID" required>
          </el-input>
        </el-form-item>

        <el-form-item label="行政类型" prop="leader_type">
          <el-select v-model="newform.leader_type" placeholder="请选择行政类型">
            <el-option label="中层" :value="1">中层</el-option>
            <el-option label="学校" :value="2">学校</el-option>
          </el-select>
        </el-form-item>

        <el-form-item label="职务描述"  prop="job">
          <el-input v-model="newform.job"></el-input>
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
      v-show="paginationVisible"
      layout="total, prev, pager, next"
      :page-size="15"
      :total="total">
    </el-pagination>

  </div>
</template>

<script>
  import { getToken } from "@/utils/auth";
  import {
    getLeader,
    getLeaderById,
    addNewLeader,
    updateLeaderInfo,
    deleteLeaderById
  } from "@/api/leader";
  // import {
  //   getTeacher
  // } from "@/api/getTeacher";
  import leaderConfig from "./../../../static/config";

function Leader (session_id = null, teacher_id = null, leader_type = null, job = null, remark = null) {
  this.session_id = session_id
  this.teacher_id = teacher_id
  this.leader_type = leader_type
  this.job = job
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
      paginationVisible: true,
      resetId: "",
      uploadId: "",
      form: {
        id: "",
        session_id: 0,
        teacher_id: 0,
        leader_type: "",
        job: "",
        remark: ""
      },
      newform: new Leader(),
      current_page: 1,
      leader_type_search: "",
      total: 0,
      options: [{
          value: '选项1',
          label: '中层'
        }, {
          value: '选项2',
          label: '学校'
        }, {
          value: '选项3',
          label: '全部'
      }],
      value8: '',
      teacherData:[],
      search_teacherID:''
    }
  },
  methods:{
    fetchData() {
      getLeader()
        .then(response => {
          //成功执行内容
          let result = response.data;
          // console.log(result);
          this.tableData = result;
          this.total = response.meta.total;
          for(var i=0;i<result.length;i++){
            // console.log(result[i].leader_type);
            this.tableData[i].leader_type =
              result[i].leader_type == '1'?'中层':'学校';
          }
        })
        .catch(() => {
          //失败执行内容
        });
      // console.log(this.teacherData);
      getTeacher().then(response => {
          let result = response.data;
          this.teacherData = result;
          console.log(this.teacherData);
        })
        .catch(() => {

        });
    },
    add () {
      this.addDialogFormVisible = true;
    },
    edit (row) {
      let id = row.id;
      this.uploadId = id;
      getLeaderById(id).then(response => {
        let result = response.data;
        this.form = result;
        this.editDialogFormVisible = true;
      });
    },
    saveData () {
      updateLeaderInfo(this.uploadId, this.form).then(response => {
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
          for(var i=0;i<this.tableData.length;i++){
            // console.log(this.tableData[i].leader_type);
            this.tableData[i].leader_type =
              this.tableData[i].leader_type == '1'?'中层':'学校';
          }
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
      this.newform = new Leader();
      this.resetDialogFormVisible = true;

    },
    submitForm () {
      addNewLeader(this.newform).then(response => {
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

          deleteLeaderById(id).then(response => {
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
      getLeader(current_page).then(response => {
        let result = response.data;
        this.tableData = result;
        console.log(this.tableData);
        for(var i=0;i<result.length;i++){
          this.tableData[i].leader_type =
            result[i].leader_type == '1'?'中层':'学校';
        }
      })
    },
    handleCommand(command) {
      console.log(command);
      let leader_type_search = command;
      this.leader_type_search = leader_type_search;
      getLeader(leader_type_search).then(response => {
        let result = response.data;
        this.tableData = result;
        console.log(this.tableData);
        for(var i=0;i<result.length;i++){
          this.tableData[i].leader_type =
          result[i].leader_type == '1'?'中层':'学校';
        }
      })
    },
    searchTeacherID(){
      getLeaderById (this.search_teacherID).then(response=>{
        let result = response.data;
        console.log(result);
        this.tableData = [];
        this.tableData.push(result);
        this.paginationVisible = false;
      }).catch(() => {
        if(this.search_teacherID == ''){
          this.fetchData();
        }else{
          this.$message({
            type: "false",
            message: "查无此人!"
          });
          this.tableData = [];
          this.paginationVisible = false;
        }
      });
    }
  },
  mounted(){
    this.fetchData();
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
.el-input{
  width: 200px;
  margin-left: 10px;
}
</style>
