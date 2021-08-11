<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <title>{$title?:config('seo.title')}</title>
    <meta name="keywords" content="{$keywords?:config('seo.keywords')}" />
    <link rel="stylesheet" type="text/css" href="/public/ask/css/style.css" />
</head>

<body>

    <header>
        <div class="mw1024">
            <div class="logo">
                <a href="/">{:config("seo.name")}</a>
            </div>
            <div class="nav">
                <ul>
                    <li><a href="/">首页</a></li>
                    <li><a href="/ask/rand.html">随机问答</a></li>
                </ul>
                {if condition="$_SERVER['user_id']"}
                <ul>
                    <li><a href="/ask/unanswered.html">未回复</a></li>
                    <li><a href="/ask/add.html">发布</a></li>
                </ul>
                {else /}
                
                {/if}
            </div>
        </div>
    </header>