# 起源（XXX学校工作网）

本项目用于学校内部的日常管理，用于代替先前的手工管理，从而改变如今的资料存放不集中，管理杂乱无章法、不规范的况状，计划实现以下几个功能：
- 教职工基本信息管理
- 教师成长记录管理
- 学校内部校讯通功能
- 学校教职工工资信息导入和查询
- 学校内部各种固定资产的登记、外借、回收管理
- 学校微信公众平台的基础管理、普通消息群发，模板消息发送等常用功能
- 教师、家长微信端基本功能查询  工资查询 电话号码查询
- 学校公众号管理（菜单和消息回复）
- 学校内部简单事项审批和记录

## 技术栈

laravel5.5 + vuejs 2.5.2 + vue-router + vuex +element ui 2.0 + easywechat

- 后端模块 backend目录  使用[laravel5.5](http://laravelacademy.org/)框架 利用laravel passport来实现oauth 2.0认证，后端只负责开发api，
  实现主流意义上的前后端分离开发，并配置有相关的接口文档
  
- 前端模块 frontend目录  使用相关开源框架 [vueAdmin-template](https://github.com/PanJiaChen/vueAdmin-template) 
  并结合自己的需求改进而来  项目基于element ui 2.0 并使用了前端的权限管理
  
- 微信端 wx目录  计划中  使用开源微信SDK--[easywechat](https://www.easywechat.com/)主要给家长、教师提供更好的查询页面  查找各类信息

## 知识点
虽然项目暂不涉及到高大上的高并发、大数据等内容，但下面的内容或许会是你需要的：
>- **前后端分离的代码编写方式  项目发布方式**
>- **laravel中oauth2.0的认证**
>- **vue.js中如何结合后台api进行开发 如何在前端控制用户的登陆以及对数据的访问的权限**
>- **结合实际开发中的webpack的各种配置方式**
  
## 项目测试
- 后端使用了laravel 可以参考backend中的[相关资料](https://github.com/wmhello/workManger/blob/master/backend/%E9%A1%B9%E7%9B%AE%E5%90%8E%E5%8F%B0%E5%AE%89%E8%A3%85.md)进行发布与测试  后端只提供api接口和api文档
  系统登录密码从backend\database\seeds里面去找 具体可以参考laravel教程
- 前端使用了vue.js 技术  可以参考vue.js的项目流程来进行发布与测试

# 项目界面截图
#### 系统首页
![系统首页](https://i.loli.net/2021/11/24/J1wQsvdxhyRB4pA.png)

#### 系统用户管理
![用户管理](https://i.loli.net/2021/11/24/EhIDbx8KQim3ZYg.png)

#### 用户角色管理
![角色管理](https://i.loli.net/2021/11/24/wCWfAPMoxuZiBLY.png)

#### 系统功能权限管理
![功能管理](https://i.loli.net/2021/11/24/cCGHxOBNYIA6ikT.png)

#### 教学学期管理
![教学学期管理](https://i.loli.net/2021/11/24/XzlbWpkSNC5FTcw.png)

#### 学校行政管理
![学校行政管理](https://i.loli.net/2021/11/24/h3pqVnec618uOAR.png)

#### 教职工信息管理
![教职工信息管理](https://i.loli.net/2021/11/24/wjSKZN6I93LUisH.png)

#### 教职工工资管理
![教职工工资管理](https://i.loli.net/2021/11/24/ETlqkWY9NnBuOmK.png)

#### 教职工工资导入
![教职工工资导入](https://i.loli.net/2021/11/24/vlIwFJNtZXT9f6o.png)

#### 微信公众号消息模板发送
![微信公众号消息模板发送](https://i.loli.net/2021/11/24/LR5B3XNUFIq1Gs8.png)

#### 微信端学校资讯管理
![微信端学校资讯](https://i.loli.net/2021/11/24/yCWPZjfNIcX7nBO.png)

#### 微信公众号菜单管理
![微信公众号菜单管理](https://i.loli.net/2021/11/24/qwsyxvtfSBAWVzo.png)

#### 学校事项审批设定
![学校事项审批设定](https://i.loli.net/2021/11/24/aKzB1V7jedmpu4o.png)

#### 功能室使用审批和记录
![功能室使用审批和记录](https://i.loli.net/2021/11/24/MZO6kbGjmEPsBNY.png)


# 说明

>  如果对您有帮助，您可以点右上角 "Star" 支持一下 谢谢！ ^_^

>  或者您可以 "follow" 一下，我会不断完善该项目

>  开发环境 windows 7  Chrome 63  PHP 7.1.7

>  如有问题请直接在 Issues 中提，或者您发现问题并有非常好的解决方案，欢迎 PR 👍

>  项目交流：xpyzwm(微信)

# 致谢
  站在巨人之上，我们才能走得更远。项目中使用到了以下开源框架 一并致谢
>- laravel(https://laravel.com/) 
>- vue.js(https://cn.vuejs.org/index.html)
>- element ui(http://element.eleme.io/#/zh-CN) 
>- vue全家桶(https://router.vuejs.org/ https://vuex.vuejs.org/)
>- 微信集成(https://github.com/overtrue/laravel-wechat)
>- excel插件(https://github.com/Maatwebsite/Laravel-Excel)
>- 跨域(https://github.com/barryvdh/laravel-cors)
>- 短信集成(https://github.com/overtrue/easy-sms)
>- vueAdmin-template(https://github.com/PanJiaChen/vueAdmin-template)
>- API接口文档书写(http://apidocjs.com/)

# License

[MIT](https://github.com/wmhello/workManger/LICENSE)

