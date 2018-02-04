<template>

</template>

<script>
export default {
  name: "UploadXls",
  props: {
    show: Boolean,
    templateFile: String,
    module: String
  },
  data() {
    return {};
  },
  computed: {
    uploadDialogFormVisible() {
      return this.show;
    }
  },
  methods: {
    cancelUpload() {
      this.$emit("close-upload");
    },
    saveUpload() {
      this.$emit("close-upload");
    },
    downloadTemplate() {
      location.href = this.templateFile;
    },
    submitUpload() {
      this.$confirm('是否上传指定的内容', '提示', {
          confirmButtonText: '确定',
          cancelButtonText: '取消',
          type: 'warning'
        }).then(() => {
           console.log()
          //this.$refs.upload.submit();
        }).catch(()=>{
          console.log('上传操作取消')
        })
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
      import(`./../../api/${this.module}`).then(
        ({uploadFile}) => {
          uploadFile(fd).then(res => {
               this.$message({
                  message: '文件信息上传成功',
                  type: 'success'
              })
           this.$parent.fetchData();
           });
        return true;
        })
    },
  }
};
</script>


<style lang="sass" scoped>

</style>
