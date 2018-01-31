<template>
  <div id="leader">
       <el-form id="toolbar" :inline="true" :model="formInline" class="demo-form-inline">
          <el-form-item label="姓名">
            <el-select v-model="formInline.teacher_id" clearable filterable placeholder="请查找或选择">
                  <el-option v-for="item in teachers" :key="item.id" :label="item.name" :value="item.id">
                  </el-option>
            </el-select>
          </el-form-item>
         <el-form-item label="行政类型">
             <el-select v-model="formInline.leader_type" clearable placeholder="行政类型">
                 <el-option label="中层领导" value="1"></el-option>
                 <el-option label="学校领导" value="2"></el-option>
             </el-select>
       </el-form-item>
           <el-form-item label="学期">
               <el-select v-model="formInline.session_id" clearable placeholder="学期">
                   <el-option v-for="item in sessions" :label="item.remark |adjustSessionMark(item)" :value="item.id" :key="item.id"></el-option>
               </el-select>
           </el-form-item>
           <el-form-item>
               <el-button  @click="search" plain>查询</el-button>
               <el-button type="info" @click="searchReset" plain>重置</el-button>
           </el-form-item>
     </el-form>
  <div id="datagrid">
    <div class="toolbar">
      <el-button  plain icon="el-icon-plus" @click="add()">添加</el-button>
      <el-button  plain icon="el-icon-download" @click="add()">导出</el-button>
      <el-button  plain icon="el-icon-upload" @click="add()">导入</el-button>
    </div>
    <!-- 学校行政列表 -->
    <el-table :data="tableData" border style="width: 100%">
      <el-table-column prop="id" label="序号" width="70">
      </el-table-column>
      <el-table-column label="教师" width="120">
          <template slot-scope="scope">
              <span>{{scope.row.teacher_id|getTeacherName(teachers) }}</span>
          </template>
      </el-table-column>
      <el-table-column label="行政类型" width="120">
          <template slot-scope="scope">
                      <el-tag
          :type="scope.row.leader_type === 1 ? 'primary' : 'success'"
          close-transition>{{scope.row.leader_type==1?'中层':'学校'}}</el-tag>
          </template>
      </el-table-column>
      <el-table-column prop="job" label="职务描述" width="180">
      </el-table-column>
      <el-table-column prop="remark" label="备注" width="300">
      </el-table-column>
      <el-table-column label="操作">
        <template slot-scope="scope">
          <el-tooltip content="编辑" placement="right-end"  effect="light">
            <el-button plain icon="el-icon-edit" type="primary" size="small" @click="edit(scope.row)"></el-button>
          </el-tooltip>
          <el-tooltip content="删除" placement="right-end"  effect="light">
            <el-button plain icon="el-icon-delete" type="danger" size="small" @click="del(scope.row)"></el-button>
          </el-tooltip>
        </template>
      </el-table-column>
    </el-table>
    <!-- 分页 -->
    <div class="pagination">
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
  </div>
        <!-- 编辑列表 -->
    <el-dialog title="行政信息" center :visible.sync="editDialogFormVisible" :close-on-click-modal="false">
      <el-form :model="form" label-width="100px">
        <el-row>
          <el-col :span="12">
        <el-form-item label="教师"  >
            <el-select v-model="form.teacher_id" filterable placeholder="请选择">
                  <el-option v-for="item in teachers" :key="item.id" :label="item.name" :value="item.id">
                  </el-option>
            </el-select>
        </el-form-item>
          </el-col>
          <el-col :span="12">
        <el-form-item label="行政类型" prop="leader_type">
          <el-select v-model="form.leader_type" placeholder="请选择行政类型">
            <el-option label="中层" :value="1">中层</el-option>
            <el-option label="学校" :value="2">学校</el-option>
          </el-select>
        </el-form-item>
          </el-col>
        </el-row>
        <el-row>
          <el-col :span="12">
        <el-form-item label="职务描述"  prop="job">
          <el-input v-model="form.job"></el-input>
        </el-form-item>
          </el-col>
          <el-col :span="12">
        <el-form-item label="备注"  prop="remark">
          <el-input v-model="form.remark"></el-input>
        </el-form-item>
          </el-col>
        </el-row>
        </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="editDialogFormVisible = false">取 消</el-button>
        <el-button type="primary" @click="saveData()">确 定</el-button>
      </div>
    </el-dialog>

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
import { getSession, getTeacher, getDefaultSession} from "@/api/other";
import leaderConfig from "./../../../static/config";

function Leader(
  session_id = null,
  teacher_id = null,
  leader_type = null,
  job = null,
  remark = null
) {
  this.session_id = session_id;
  this.teacher_id = teacher_id;
  this.leader_type = leader_type;
  this.job = job;
  this.remark = remark;
}

function SearchTemplate(teacher_id= null, leader_type=null, session_id = null)
{
    this.teacher_id = teacher_id
    this.leader_type = leader_type
    this.session_id = session_id
}

export default {
  data() {
    return {
      formInline: new SearchTemplate(),
      tableData: [],
      dialogFormVisible: false,
      editDialogFormVisible: false,
      paginationVisible: true,
      resetId: "",
      uploadId: "",
      teachers: [],
      sessions: [],
      form: {
        id: "",
        session_id: 0,
        teacher_id: 0,
        leader_type: "",
        job: "",
        remark: ""
      },
      session_id: null,
      isNew: false,
      isEdit: false,
      leaderType: ["无", "中层", "学校"],
      newform: new Leader(),
      current_page: 1,
      leader_type_search: "",
      total: 0,
      value8: "",
      teacherData: [],
      search_teacherID: ""
    };
  },
  methods: {
    fetchData() {
      getLeader()
        .then(response => {
          //成功执行内容
          let result = response.data;
          this.tableData = result;
          this.total = response.meta.total;
        })
        .catch(() => {
          //失败执行内容
        });
    },
    add() {
      this.editDialogFormVisible = true;
      this.isNew = true;
      this.form = new Leader();
    },
    edit(row) {
      let id = row.id;
      this.uploadId = id;
      getLeaderById(id).then(response => {
        let result = response.data;
        this.form = result;
        this.isEdit = true;
        this.editDialogFormVisible = true;
      });
    },
    saveData() {
      this.editDialogFormVisible = false;
      if (this.isNew) {
        this.isNew = false
        this.addLeaderData()
      }
      if (this.isEdit) {
        this.isEdit = false
        this.updateLeaderData()
      }

    },
    updateLeaderData() {
      updateLeaderInfo(this.uploadId, this.form)
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
            this.$message({
                  type: "success",
                  message: "用户信息更新成功"
            });
          }
        })
        .catch(() => {
          //失败执行内容
          console.log("连接失败");
          // console.log(error.response);
        });
    },
    addLeaderData() {
      addNewLeader(this.form)
        .then(response => {
            this.$message({
                  type: "success",
                  message: "用户信息添加成功"
            });
        })
        .catch(error => {
          console.log(error.response);
        });
    },

    // 搜索相关
    search () {
       console.log(this.formInline)
    },
    searchReset() {
      this.formInline = new SearchTemplate('', null, this.session_id)
    },

    del(row) {
      this.$confirm("此操作将永久删除该信息, 是否继续?", "提示", {
        confirmButtonText: "确定",
        cancelButtonText: "取消",
        type: "warning"
      })
        .then(() => {
          let id = row.id;
          let record = null;
          record = this.tableData.findIndex(val => val.id == id);
          deleteLeaderById(id)
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
              console.log("删除失败");
            });
        })
        .catch(() => {});
    },
    // 分页相关
    handleCurrentChange(val) {
      let current_page = val;
      this.current_page = current_page;
      getLeader(current_page).then(response => {
        let result = response.data;
        this.tableData = result;
      });
    },
    handleCommand(command) {
      console.log(command);
      let leader_type_search = command;
      this.leader_type_search = leader_type_search;
      getLeader(leader_type_search).then(response => {
        let result = response.data;
        this.tableData = result;
      });
    },
    getSessions() {
      // 获取学期信息
      return new Promise((resolve, reject) => {
        getSession()
          .then(response => {
            this.sessions = response.data;
            resolve("sessions ok");
          })
          .catch(err => {
            reject("学期信息调用出错");
          });
      });
    },
    getTeachers() {
      // 获取教师姓名和id信息
      return new Promise((resolve, reject) => {
        getTeacher()
          .then(response => {
            this.teachers = response.data;
            resolve("teachers ok");
          })
          .catch(err => {
            reject("教师信息调用出错");
          });
      });
    },

  },
  mounted() {
    Promise.all([this.getSessions(), this.getTeachers()]).then(res => {
      this.fetchData();
      getDefaultSession().then(response => {
        let result = response.data;
        this.session_id = result.id
        this.formInline = new SearchTemplate('', null, this.session_id)
      })
    });
  },
  filters: {
    getTeacherName(value, teachers) {
      let item = teachers.find(val => val.id == value);
      return item.name;
    },
    getLeaderType(value, leaderType) {
      return leaderType[value];
    },
    adjustSessionMark(value, item){
      let year = item.year + 1
      let teamNote = item.team==1? '上学期': '下学期'
      return item.year+'-'+year+'学年'+teamNote
    }
  }
};
</script>

<style lang="scss">
 @import './../../styles/app-main.scss';
#leader .el-input {
  width: 200px;
  margin-left: 10px;
}
</style>
