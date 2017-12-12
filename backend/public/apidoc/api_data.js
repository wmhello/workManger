define({ "api": [
  {
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "optional": false,
            "field": "varname1",
            "description": "<p>No type.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "varname2",
            "description": "<p>With type.</p>"
          }
        ]
      }
    },
    "type": "",
    "url": "",
    "version": "0.0.0",
    "filename": "./public/apidoc/main.js",
    "group": "D__laragon_www_wx_public_apidoc_main_js",
    "groupTitle": "D__laragon_www_wx_public_apidoc_main_js",
    "name": ""
  },
  {
    "type": "get",
    "url": "/api/user",
    "title": "获取当前登陆的用户信息",
    "group": "login",
    "success": {
      "examples": [
        {
          "title": "信息获取成功",
          "content": "HTTP/1.1 200 OK\n{\n\"data\": {\n   \"id\": 1,\n   \"name\": \"xxx\",\n   \"email\": \"xxx@qq.com\",\n   \"roles\": \"xxx\", //角色: admin或者editor\n   \"avatar\": \"\"\n },\n \"status\": \"success\",\n \"status_code\": 200\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "./routes/api.php",
    "groupTitle": "login",
    "name": "GetApiUser"
  },
  {
    "type": "post",
    "url": "/api/login",
    "title": "用户登陆",
    "group": "login",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "email",
            "description": "<p>用户email</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "password",
            "description": "<p>用户密码</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "登陆成功",
          "content": "HTTP/1.1 200 OK\n{\n\"token\": \"eyJ0eXAiOiJKV1QiLCJhbGciOiJS\",\n\"expires_in\": 900 // 过期时间\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "用户身份验证失败",
          "content": "HTTP/1.1 421 用户名或者密码输入错误\n{\n\"status\": \"login error\",\n\"status_code\": 421,\n\"message\": \"Credentials not match\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "./app/Http/Controllers/Auth/LoginController.php",
    "groupTitle": "login",
    "name": "PostApiLogin"
  },
  {
    "type": "post",
    "url": "/api/logout",
    "title": "注销用户登陆",
    "group": "login",
    "success": {
      "examples": [
        {
          "title": "注销成功",
          "content": "HTTP/1.1 200 OK\n{\n\"status\": \"success\",\n\"status_code\": 200,\n\"message\": \"logout success\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "./app/Http/Controllers/Auth/LoginController.php",
    "groupTitle": "login",
    "name": "PostApiLogout"
  },
  {
    "type": "post",
    "url": "/api/token/refresh",
    "title": "Token刷新",
    "group": "login",
    "success": {
      "examples": [
        {
          "title": "刷新成功",
          "content": "HTTP/1.1 200 OK\n{\n\"token\": \"eyJ0eXAiOiJKV1QiLCJhbGciOiJS\",\n\"expires_in\": 900 // 过期时间\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "刷新失败",
          "content": "HTTP/1.1 401 未认证\n{\n\"status\": \"login error\",\n\"status_code\": 401,\n\"message\": \"Credentials not match\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "./app/Http/Controllers/Auth/LoginController.php",
    "groupTitle": "login",
    "name": "PostApiTokenRefresh"
  }
] });
