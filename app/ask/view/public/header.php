<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
<title>Z-blogPHP响应式网赚项目、知识问答网站主题</title>
<meta name="Keywords" content="网赚主题,网赚项目,知识分享,问答网站,响应式" />
<meta name="description" content="使用网赚项目问答的形式帮助网赚类网站突出重点，也可以做一个知识问答分享类的网站。自适应主题模板，支持手机、平板和电脑访问！" />
<meta name="author" content="星岚工作室" />
<link rel="stylesheet" type="text/css" href="/public/ask/css/style.css" />
</head>
<body>

<header>
    <div class="mw1024">
        <div class="logo">
            <a href="/">
                <img src="http://wz01.hnysnet.com/zb_users/theme/hnyswz/style/logo.png" alt="响应式首页问答网赚主题">
            </a>
        </div>
        <div class="nav">
            <ul>
                <li><a href="/">首页</a></li>
            </ul>
            {if condition="$_SERVER['user_id']"}
            <ul>
                <li><a href="/ask/unanswered">未回复</a></li>
                <li><a href="/ask/add">发布</a></li>
                <li><a href="/user/">个人中心</a></li>
            </ul>
            {else /}
            <ul>
                <li><a href="/sign/login">登录</a></li>
                <li><a href="/sign/reg">注册</a></li>
            </ul>
            {/if}
        </div>
    </div>
</header>