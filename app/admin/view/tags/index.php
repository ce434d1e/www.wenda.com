<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
<title>标签</title>
<meta name="Keywords" content="" />
<meta name="description" content="" />
</head>
<body>

<form method="post" action="add" id="add_form">
	<button>批量添加</button>
</form>

<a href="/admin/tags/add">批量添加</a>

<br>
<br>

<div id="list">
{volist name="list" id="vo"}
<a href="/admin/tags/{$vo.tags_id}.html">{$vo.tags_name}</a>
{/volist}
</div>

<style type="text/css">
form{
	display: none;
}
form textarea{
	border: 1px solid #ccc;
	width: 80%;
	height: 100px;
}
form button{
	width: 20%;
	margin-left: 10px;
}

#list a{
	border: 1px solid #ccc;
	border-radius: 3px;
	font-size: 12px;
	text-decoration: none;
	padding: 4px 6px;
}

</style>

</body>
</html>