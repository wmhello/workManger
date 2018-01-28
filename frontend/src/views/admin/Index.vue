<template>
  <div>
    <el-table :data="tableData" :border="true" style="width: 100%">
      <el-table-column prop="id" label="序号" width="70">
      </el-table-column>
      <el-table-column prop="name" label="姓名" width="100">
      </el-table-column>
      <el-table-column prop="email" label="email">
      </el-table-column>
      <el-table-column  label="权限" width="150" class="box">
      <template slot-scope="scope" >

        <el-tag style="margin-right: 5px" v-for="item in scope.row.role" :key="item" size="medium">{{item|roleFilter(roles)}}</el-tag>
        <!-- <span style="margin-left: 10px">{{ scope.row.role|roleFilter(roles) }}</span> -->
      </template>
      </el-table-column>
      <el-table-column  label="头像" width="80">
        <template slot-scope="scope">
           <img v-if="scope.row.avatar" :src="scope.row.avatar|avatarFilter" alt="" width="50" height="50">
        </template>
      </el-table-column>

      <el-table-column label="操作">
        <template slot-scope="scope">
          <el-tooltip content="编辑" placement="top">
            <el-button size="small" plain icon="el-icon-edit-outline" @click="edit(scope.row)"></el-button>
          </el-tooltip>
          <el-tooltip content="重置密码" placement="top">
            <el-button plain icon="el-icon-setting" size="small" @click="reset(scope.row)"></el-button>
          </el-tooltip>
          <el-tooltip content="删除" placement="top">
            <el-button plain icon="el-icon-delete" type="danger" size="small" @click="del(scope.row)"></el-button>
          </el-tooltip>
        </template>
      </el-table-column>
    </el-table>

    <el-dialog title="用户信息" :visible.sync="editDialogFormVisible" :close-on-click-modal="false">
      <el-form :model="form" label-width="80px">
        <el-form-item label="姓名">
          <el-input v-model="form.name"></el-input>
        </el-form-item>
        <el-form-item label="邮箱">
          <el-input v-model="form.email"></el-input>
        </el-form-item>
        <el-form-item label="用户权限">
          <el-select v-model="form.role" multiple placeholder="用户权限">
            <el-option v-for="item in roles"  :key="item.name" :label="item.explain" :value="item.name">{{item.explain}}</el-option>
          </el-select>
        </el-form-item>
        <el-form-item label="用户头像">
       <el-upload class="avatar-uploader" drag ref="upload" action="123" accept=".jpg,.png" :before-upload="beforeUpload">
        <img v-if="form.avatar" :src="imageUrl" class="avatar">
        <i v-else class="el-icon-plus avatar-uploader-icon"></i>
         <div slot="tip" class="el-upload__tip">点击上传头像，只能上传jpg/png格式文件。</div>
      </el-upload>
        </el-form-item>
      </el-form>

      <div slot="footer" class="dialog-footer">
        <el-button @click="editDialogFormVisible = false">取 消</el-button>
        <el-button type="primary" @click="saveData()">确 定</el-button>
      </div>
    </el-dialog>

    <el-dialog title="密码重置" :visible.sync="resetDialogFormVisible" :close-on-click-modal="false">
      <el-form :model="form2" label-width="100px">
        <el-form-item label="请输入新密码">
          <el-input v-model="form2.psw" type="password"></el-input>
        </el-form-item>
        <el-form-item label="再次确认密码">
          <el-input v-model="form2.newpsw" type="password"></el-input>
        </el-form-item>
      </el-form>

      <div slot="footer" class="dialog-footer">
        <el-button @click="resetDialogFormVisible = false">取 消</el-button>
        <el-button type="primary" @click="submit()">确 定</el-button>
      </div>
    </el-dialog>

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
  getAdmin,
  getAdminById,
  resetAdminByPsw,
  uploadAdminByImg,
  updataAdminInfo,
  deletAdminById,
  getCurrentPage
} from "@/api/admin";
import {getRoles }  from "@/api/role";

import adminConfig from "./../../../static/config";

export default {
  data() {
    return {
      imageUrl: "",
      fileList: [],
      uploadHeader: {
        Authorization: "Bearer " + getToken(),
        Accept: "application/json, text/plain"
      },
      importFileUrl: "/api/admin/upload",
      tableData: [],
      dialogFormVisible: false,
      resetDialogFormVisible: false,
      editDialogFormVisible: false,
      resetId: "",
      uploadId: "",
      form: {
        id: "",
        name: "",
        email: "",
        role: "",
        avatar: ""
      },
      form2: {
        psw: "",
        newpsw: ""
      },
      roles: [],
      current_page: 1,
      path: "http://wmhello.natapp1.cc/api/admin",
      total: 0
    };
  },
  methods: {
    // 头像上传
    beforeUpload(file) {
      let fd = new FormData();
      fd.append("photo", file);
      uploadAdminByImg(fd).then(res => {
        let file = res.data.url;
        this.form.avatar = file;
        this.imageUrl = adminConfig.site + file;
      });
      return true;
    },
    fetchData() {
      getAdmin()
        .then(response => {
          //成功执行内容
          let result = response.data;
          this.tableData = result;
          this.total = response.meta.total;
          //console.log(this.total);
        })
        .catch(() => {
          //失败执行内容
        });
    },
    edit(row) {
      let id = row.id;
      this.uploadId = id;
      getAdminById(id).then(response => {
        let result = response.data;
        this.form = result;
        // 显示图像
        if (result.avatar) {
          this.imageUrl = adminConfig.site + result.avatar;
        } else {
          this.imageUrl = "";
        }
        this.editDialogFormVisible = true;
      });
    },
    reset(row) {
      this.form2 = {
        psw: "",
        newpsw: ""
      };
      this.resetDialogFormVisible = true;
      this.resetId = row.id;
    },
    submit() {
      if (this.form2.psw == this.form2.newpsw && this.form2.psw) {
        let password = this.form2.psw;
        resetAdminByPsw(this.resetId, password).then(response => {
          let result = response.status_code;
          if (result == 200) {
            this.$message.success({
              message: "恭喜你，重置密码成功"
            });
            this.resetDialogFormVisible = false;
          }
        });
      } else {
        this.$message.error({
          message: "输入密码为空或两次输入密码不同，请重新输入！"
        });
        this.resetDialogFormVisible = false;
      }
    },
    saveData() {
      updataAdminInfo(this.uploadId, this.form)
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
            this.editDialogFormVisible = false;
          }
        })
        .catch(() => {
          //失败执行内容
        });
    },
    del(row) {
      this.$confirm("此操作将永久删除该用户, 是否继续?", "提示", {
        confirmButtonText: "确定",
        cancelButtonText: "取消",
        type: "warning"
      })
        .then(() => {
          let id = row.id;
          let record = null;
          record = this.tableData.findIndex(val => val.id == id);

          deletAdminById(id)
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

    // 分页功能
    handleCurrentChange(val){
      let current_page = val;
      this.current_page = current_page;
      //console.log(`当前页: ${val}`);
      getCurrentPage(current_page).then(response => {
          let result = response.data;
          this.tableData = result;
        })
    },
    getRoleAll() {
       getRoles().then(res => {
         this.roles = res.data
       })
       .catch(err => {

       })
    }
  },
  mounted() {

  },
  beforeCreate() {
        getRoles().then(res => {
         this.roles = res.data
         this.fetchData()
       })
       .catch(err => {
       })
  },
  filters: {
    roleFilter(val, items) {
/*             let arrRoles = val;
            let strRoles = ''
            arrRoles.forEach(role => {
              let strRole = items.find(item => item.name == role)
              strRoles += strRole.explain + ''
            })
            return strRoles */
            let role = items.find(item => item.name == val)
            return  role.explain

    },
    avatarFilter(val) {
      return adminConfig.site + val;
    }
  }
};
</script>

<style>
.avatar-uploader .el-upload {
  border: 1px dashed #d9d9d9;
  border-radius: 6px;
  cursor: pointer;
  position: relative;
  overflow: hidden;
}

.avatar-uploader .el-upload:hover {
  border-color: #20a0ff;
}

.avatar-uploader-icon {
  font-size: 28px;
  color: #8c939d;
  width: 178px;
  height: 178px;
  line-height: 178px;
  text-align: center;
}

.avatar {
  width: 178px;
  height: 178px;
  display: block;
}

.el-pagination{
  padding: 0;
  margin-top: 20px;
  text-align: right;
}
</style>
