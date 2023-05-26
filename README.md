# laravel-custom
个人自定义laravel项目，用于快速构建laravel/lumen api项目<br/>

## 目录结构

- Support 存放支持项目运行的类与助手函数文件helper.php
- Support/Traits 存放项目用到的trait
- Services 存放服务类 包括三方接口服务类、项目服务类等
- Constants 存放常量类、枚举类 

## 统一api json响应
#### 响应结构
``` code
{
    "code": 1, // int 类型
    "data": {}, // object 类型
    "msg": "成功" // string 类型
}
```
#### 响应码、响应msg枚举
详见 [ResponseCode](./app/Constants/ResponseCode.php)

## 异常
#### 统一异常处理
#### 统一异常api json响应

## 统一分页接口入参、出参

## 统一http client

## 日志
#### 通过request id 打通日志链路
#### 请求、响应日志记录
#### sql日志监听
#### redis命令日志监听

## 串行化（防止资源同一时间被占用）中间件

## 为Eloquent Model定义实用宏方法

## 定义 service controller model基类

## 异步执行类
实现响应http请求后继续占用php-fpm进程执行任务

