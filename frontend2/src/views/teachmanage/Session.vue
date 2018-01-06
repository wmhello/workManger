<template>
  <div>
    <el-button type="primary" plain size="large" icon="el-icon-document" @click="add()">添加</el-button>
    <div style="margin-bottom: 10px;"></div>
    <el-table :data="tableData" :border="true" style="width: 80%" scope="scope">
      <el-table-column prop="id" label="序号" width="80">
      </el-table-column>
      <el-table-column prop="year" label="学年">
      </el-table-column>

      <el-table-column prop="team" label="学期">
      </el-table-column>

      <el-table-column prop="one" label="高一班级数">
      </el-table-column>

      <el-table-column prop="two" label="高二班级数">
      </el-table-column>

      <el-table-column prop="three" label="高三班级数">
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

     <el-dialog title="学期信息" :visible.sync="editDialogFormVisible" :close-on-click-modal="false">
      <el-form :model="form" label-width="100px">
        <el-form-item label="学年"  prop="year">
         <el-date-picker v-model="form.year" align="right" type="year" placeholder="选择年">
      </el-date-picker>
        </el-form-item>

          <el-form-item label="学期" prop="team">
          <el-select v-model="form.team" placeholder="请选择学期">
            <el-option label="上学期" :value="1">上学期</el-option>
            <el-option label="下学期" :value="2">下学期</el-option>
          </el-select>
        </el-form-item>

        <el-form-item label="高一班级数"  prop="one">
          <el-input v-model="form.one" auto-complete="off"></el-input>
          </el-form-item>

          <el-form-item label="高二班级数"  prop="two">
          <el-input v-model="form.two" auto-complete="off"></el-input>
          </el-form-item>

          <el-form-item label="高三班级数"  prop="three">
          <el-input v-model="form.three" auto-complete="off"></el-input>
          </el-form-item>
      </el-form>

      <div slot="footer" class="dialog-footer">
        <el-button @click="editDialogFormVisible = false">取 消</el-button>
        <el-button type="primary" @click="saveData()">确 定</el-button>
      </div>
    </el-dialog>

    <el-dialog title="学期信息" :visible.sync="addDialogFormVisible" :close-on-click-modal="false">
    <el-form :model="newform"   label-width="100px">
      <el-form-item label="学年" prop="year">
        <el-date-picker v-model="newform.year" align="right" type="year" placeholder="选择年">
      </el-date-picker>
      </el-form-item>

      <el-form-item label="学期" prop="team">
        <el-select v-model="newform.team" placeholder="请选择学期">
          <el-option label="上学期" :value="1">上学期</el-option>
          <el-option label="下学期" :value="2">下学期</el-option>
        </el-select>
      </el-form-item>

      <el-form-item label="高一班级数"  prop="one">
          <el-input v-model="newform.one" auto-complete="off"></el-input>
          </el-form-item>

          <el-form-item label="高二班级数"  prop="two">
          <el-input v-model="newform.two" auto-complete="off"></el-input>
          </el-form-item>

          <el-form-item label="高三班级数"  prop="three">
          <el-input v-model="newform.three" auto-complete="off"></el-input>
          </el-form-item>

      <el-form-item>
        <el-button type="primary" @click="submitForm('newform')">立即创建</el-button>
        <el-button @click="resetForm('newform')">重置</el-button>
      </el-form-item>
    </el-form>
</el-dialog>
  </div>
</template>

<script>
import {
  getTeach,
  getTeachById,
  addNewTeach,
  updataTeachInfo,
  deletTeachById
} from "@/api/session";

function Teach (year = null, team = null, one = null, two = null, three = null) {
  this.year = year
  this.team = team
  this.one = one
  this.two = two
  this.three = three
}

export default {
  data () {
    return {
      tableData: [],
      dialogFormVisible: false,
      resetDialogFormVisible: false,
      editDialogFormVisible: false,
      addDialogFormVisible: false,
      resetId: "",
      uploadId: "",
      form: {
        id: "",
        year: "",
        team: "",
        one: "",
        two: "",
        three: ""
      },
      newform: new Teach()
    };
  },
  methods: {
    fetchData () {

      getTeach().then(response => {
        //成功执行内容
        let result = response.data;
        let count = result.length;

        for (let i = 0; i < count; i++) {
          if (result[i].team == 1) {
            result[i].team = "上学期";
          } else if (result[i].team == 2) {
            result[i].team = "下学期";
          }
        }
        this.tableData = result;
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
      getTeachById(id).then(response => {
        let result = response.data;
        this.form = result;
        this.editDialogFormVisible = true;
      });
    },
    saveData () {
      updataTeachInfo(this.uploadId, this.form).then(response => {
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
    resetForm () {
      this.newform = new Teach();
      this.resetDialogFormVisible = true;

    },
    submitForm () {
      addNewTeach(this.newform).then(response => {
        console.log(response)
        this.$alert('新建成功', '友情提示', {
          callback: action => {
            // 清空内容，重新开始建立
            this.newform = new Teach()
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

          deletTeachById(id).then(response => {
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
        .catch(() => { });
    }
  },
  mounted () {
    this.fetchData()
  },
  created () {

  }
};
</script>
