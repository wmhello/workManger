webpackJsonp([9],{"5eyz":function(e,t,a){"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.getInfo=function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:{},t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:1,a=arguments.length>2&&void 0!==arguments[2]?arguments[2]:10;return Object(n.a)({url:"/api/admin",method:"get",params:{page:t,pageSize:a,name:e.name,email:e.email}})},t.getCurrentPage=function(e){return Object(n.a)({url:"/api/admin",method:"get",params:{page:e}})},t.getInfoById=function(e){return Object(n.a)({url:"/api/admin/"+e,method:"get"})},t.resetAdminByPsw=function(e,t){return Object(n.a)({url:"/api/admin/"+e+"/reset",method:"post",data:{password:t}})},t.uploadAdminByImg=function(e){return Object(n.a)({url:"/api/admin/uploadAvatar",method:"post",data:e,headers:{"Content-Type":"multipart/form-data"}})},t.updateInfo=function(e,t){return Object(n.a)({url:"/api/admin/"+e,method:"put",params:{name:t.name,role:t.role,avatar:t.avatar},headers:{"Content-Type":"application/x-www-form-urlencoded"}})},t.deleteInfoById=function(e){return Object(n.a)({url:"/api/admin/"+e,method:"delete"})},t.addInfo=function(e){return console.log(e),Object(n.a)({url:"/api/admin",method:"post",data:e})},t.uploadFile=function(e){return Object(n.a)({url:"/api/admin/upload",method:"post",data:e,headers:{"Content-Type":"multipart/form-data"}})},t.exportCurrentPage=function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:10,t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:1,a=arguments.length>2&&void 0!==arguments[2]?arguments[2]:{};return Object(n.a)({url:"/api/admin/export",method:"post",data:{page:t,pageSize:e,name:a.name,email:a.email}})},t.exportAll=function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:{};return Object(n.a)({url:"/api/admin/exportAll",method:"post",data:{name:e.name,email:e.email}})},t.deleteAll=function(e){return Object(n.a)({url:"/api/admin/deleteAll",method:"post",data:{ids:e}})},t.Model=function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"",t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:"",a=arguments.length>2&&void 0!==arguments[2]?arguments[2]:[],n=arguments.length>3&&void 0!==arguments[3]?arguments[3]:"",o=arguments.length>4&&void 0!==arguments[4]?arguments[4]:"",i=arguments.length>5&&void 0!==arguments[5]?arguments[5]:"";this.name=e,this.email=t,this.role=a,this.avatar=n,this.password=o,this.password_confirmation=i},t.SearchModel=function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"",t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:" ";this.name=e,this.email=t};var n=a("Vo7i")}});