<template>
  <div id="leader">
       <el-form id="toolbar" :inline="true" :model="searchForm" class="demo-form-inline">
          <el-form-item label="姓名">
            <el-select v-model="searchForm.teacher_id" clearable filterable placeholder="请查找或选择">
                  <el-option v-for="item in teachers" :key="item.id" :label="item.name" :value="item.id">
                  </el-option>
            </el-select>
          </el-form-item>
         <el-form-item label="行政类型">
             <el-select v-model=" searchForm.leader_type" clearable placeholder="行政类型">
                 <el-option label="中层领导" value="1"></el-option>
                 <el-option label="学校领导" value="2"></el-option>
             </el-select>
       </el-form-item>
           <el-form-item label="学期">
               <el-select v-model="searchForm.session_id" clearable placeholder="学期">
                   <el-option v-for="item in sessions" :label="item.remark |adjustSessionMark(item)" :value="item.id" :key="item.id"></el-option>
               </el-select>
           </el-form-item>
           <el-form-item>
               <el-button  @click="find()" plain>查询</el-button>
               <el-button type="info" @click="findReset()" plain>重置</el-button>
           </el-form-item>
     </el-form>
  <div id="datagrid">
    <div class="toolbar">
      <el-button  plain icon="el-icon-plus" @click="add()">添加</el-button>
      <el-button  plain icon="el-icon-download" @click="download()">导出</el-button>
      <el-button  plain icon="el-icon-upload" @click="upload()">导入</el-button>
    </div>
    <!-- 学校行政列表 -->
    <el-table :data="tableData" border style="width: 100%">
      <el-table-column prop="id" label="序号" width="70">
      </el-table-column>
      <el-table-column label="教师" width="120">
          <template slot-scope="scope">
              <span>{{scope.row.teacher_id|getTeacherName(teachers)}}</span>
          </template>
      </el-table-column>
      <el-table-column label="行政类型" width="120">
          <template slot-scope="scope">
          <el-tag
          :type="scope.row.leader_type === 1 ? 'primary' : 'success'"
          close-transition>{{scope.row.leader_type|getLeaderType(leaderType)}}</el-tag>
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
      @current-change="pagination"
      :current-page.sync="current_page"
      layout="total, prev, pager, next"
      :total="total">
    </el-pagination>
    </div>
  </div>
        <!-- 编辑列表 -->
    <el-dialog title="行政信息" center :visible.sync="editDialogFormVisible" :close-on-click-modal="false">
      <el-form :model="form" label-width="100px">
        <el-row>
          <el-col :span="12">
        <el-form-item label="(*)教师" ref="tip">
            <el-select v-model="form.teacher_id" filterable placeholder="请选择或者输入姓名">
                  <el-option v-for="item in teachers" :key="item.id" :label="item.name" :value="item.id">
                  </el-option>
            </el-select>
        </el-form-item>
          </el-col>
          <el-col :span="12">
        <el-form-item label="(*)行政类型" prop="leader_type">
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
        <el-button @click="cancel()">取 消</el-button>
        <el-button type="primary" @click="save()">确 定</el-button>
      </div>
    </el-dialog>

      <!-- 数据导入对话框 -->
    <el-dialog title="文件导入" center :visible.sync="uploadDialogFormVisible" :close-on-click-modal="false">
      <div style="margin-bottom:10px">
           <el-button size="small" type="text" @click="downloadTemplate()">下载模板</el-button>
      </div>
        <el-upload
          class="upload-demo"
          ref="upload"
          action="123"
          :auto-upload="false"
          :before-upload="beforeUpload" accept=".xls">
        <el-button slot="trigger" size="small" type="primary">选取文件</el-button>
        <el-button style="margin-left: 10px;" size="small" type="success" @click="submitUpload()">上传到服务器</el-button>
  <div slot="tip" class="el-upload__tip">文件上传只接受xls文件</div>
</el-upload>
      <div slot="footer" class="dialog-footer">
        <el-button @click="cancelUpload()">取 消</el-button>
        <el-button type="primary" @click="saveUpload()">确 定</el-button>
      </div>
    </el-dialog>

     <!-- 数据导出对话框 -->
    <el-dialog title="数据导出" :visible.sync="exportDialogFormVisible" size="tiny" :close-on-click-modal="false">
    <div>
           <p>请选择导出的数据范围</p>
    </div>
      <div slot="footer" class="dialog-footer">
        <el-button type="primary" @click="exportType=1;exportData()">当前页</el-button>
        <el-button type="primary" @click="exportType=2;exportData()">全部</el-button>
      </div>
    </el-dialog>

  </div>
</template>

<script>
import {
  getInfo,
  getInfoById,
  addInfo,
  updateInfo,
  deleteInfoById,
  uploadFile,
  exportCurrentPage,
  exportAll,
  Model,
  SearchModel
} from "@/api/leader";
import { getSession, getTeacher, getDefaultSession} from "@/api/other";
import adminConfig from "./../../../static/config"

export default {
  data() {
    return {
      searchForm: new SearchModel(),
      tableData: [],
      editDialogFormVisible: false,
      uploadDialogFormVisible: false,
      exportDialogFormVisible: false,
      uploadId: "",
      teachers: [],
      sessions: [],
      form: new Model(),
      isNew: false,
      isEdit: false,
      leaderType: ["无", "中层", "学校"],
      current_page: 1,
      total: 0,
      pageSize: 10,
      session_id: null,
      xlsUrl: adminConfig.site + "/xls/leader.xls",
      exportXls: adminConfig.site + "/xls/行政管理.xls",
      exportType:2,
    };
  },
  methods: {
    // 搜索相关
    find() {
       this.fetchData()
    },
    findReset() {
      this. searchForm = new SearchModel(this.session_id, null,null)
      this.fetchData()
    },
    fetchData(searchObj = this.searchForm , page = this.current_page) {
      getInfo(searchObj, page)
        .then(response => {
          //成功执行内容
          let result = response.data;
          if (response.meta.total === 0) {
              this.$alert('没有找到指定的内容', '友情提示')
          } else {
           this.tableData = result;
           this.total = response.meta.total;
           this.pageCount = response.meta.last_page
          }

        })
        .catch(err => {
           this.error(err.response.data)

        });
    },
    add() {
      this.editDialogFormVisible = true;
      this.isNew = true;
      this.form = new Model();
    },
    edit(row) {
      let id = row.id;
      this.uploadId = id;
      getInfoById(id).then(response => {
        let result = response.data;
        this.form = result;
        this.isEdit = true;
        this.editDialogFormVisible = true;
      });
    },
    save() {
      this.editDialogFormVisible = false;
      if (this.isNew) {
        this.isNew = false
        this.newData()
      }
      if (this.isEdit) {
        this.isEdit = false
        this.updateData()
      }

    },
    updateData() {
      updateInfo(this.uploadId, this.form)
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
        .catch(err => {
          this.error(err.response.data)
        });
    },
    newData() {
      addInfo(this.form)
        .then(response => {
            this.$message({
                  type: "success",
                  message: "用户信息添加成功"
            });
            this.fetchData();
        })
        .catch(err => {
          this.error(err.response.data)
        });
    },
    cancel(){
      this.editDialogFormVisible = false
      this.isNew = false
      this.isEdit = false
    },
    download(){
        this.exportDialogFormVisible = true
    },
    exportData() {
      switch (this.exportType) {
        case 1:
          exportCurrentPage(this.pageSize, this.current_page, this.searchForm)
            .then(res => {
              location.href = this.exportXls;
            })
            .catch(err => {
              this.error(err.response.data);
            });
          break;
        case 2:
          exportAll(null, 1, this.searchForm)
            .then(res => {
              location.href = this.exportXls;
            })
            .catch(err => {
              this.error(err.response.data);
            });
          break;
        default:
          break;
      }
    },
    upload(){
        this.uploadDialogFormVisible = true
    },
    cancelUpload(){
        this.uploadDialogFormVisible = false
    },
    saveUpload() {
        this.uploadDialogFormVisible = false
        this.fetchData()
    },
    downloadTemplate() {
      location.href = this.xlsUrl;
    },
    beforeUpload(file) {
      if (file.type !== "application/vnd.ms-excel") {
        this.$message({
          type: 'error',
          message: '文件格式不正确，无法上传'
        })
        return false
      }
      let fd = new FormData();
      fd.append("file", file);
      uploadFile(fd).then(res => {
           this.$message({
             message: '文件信息上传成功',
             type: 'success'
           })
           this.fetchData();
      });
      return true;
    },
    submitUpload() {
      this.$confirm('上传的信息将覆盖本学期的相关数据，是否上传', '提示', {
          confirmButtonText: '确定',
          cancelButtonText: '取消',
          type: 'warning'
        }).then(() => {
          this.$refs.upload.submit();
        }).catch(()=>{
          console.log('上传操作取消')
        })
    },
    error(result){
      let tips = this.errorHandle(result)
      this.$message({
          type: "error",
          message: tips
      });
    },
    errorHandle(result) { // 处理错误
        let tips = '无法完成指定的操作，无法提供信息'
        let obj = {}
        if (result.message && typeof result.message == 'string') {
             tips = ''
             tips = result.message
        }
        if (result.message && typeof result.message == 'object') {
             tips = this.errorHandleForEachObject(result.message)
        }
        if (result.errors && typeof result.errors == 'object') {
           tips = this.errorHandleForEachObject(result.errors)
        }
        tips = tips.substr(0,tips.length-2)
        return tips
    },
    errorHandleForEachObject(obj){  // 循环编列错误对象，用于错误处理
        let tip ="";
        for( let item in obj) {
                tip =tip + obj[item].join(',')+ "☆"
          }
        return tip
    },
    del(row) {
      this.$confirm("此操作将永久删除该信息, 是否继续?", "提示", {
        confirmButtonText: "确定",
        cancelButtonText: "取消",
        type: "warning"
      }).then(() => {
          let id = row.id;
          let record = null;
          record = this.tableData.findIndex(val => val.id == id);
          deleteInfoById(id).then(response => {
              let result = response.status_code;
              if (result == 200) {
                this.$message({
                  type: "success",
                  message: "删除成功!"
                });
                this.tableData.splice(record, 1);
              }
            }).catch(err => {
              //失败执行内容
              this.error(err.response.data)
        })
      })
    },
    // 分页相关
    pagination(val) {
      this.current_page = val;
      this.fetchData()
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
  mounted() { // 操作相关的DOM
   console.log(document.querySelector('.el-dialog__body'))

  },
  created() { // 获取数据，无法操作节点
      Promise.all([this.getSessions(), this.getTeachers()]).then(res => {
      this.fetchData();
      getDefaultSession().then(response => {
        let result = response.data;
        this.session_id = result.id;
        this. searchForm = new SearchModel(this.session_id, null,null)
      })
    });
  },
  watch: {

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
