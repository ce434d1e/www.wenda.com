<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
<title>修改标签</title>
<meta name="Keywords" content="" />
<meta name="description" content="" />
</head>
<body>

<form method="post" action="">
	<textarea name="list">{$tags[0]['tags_name']}</textarea>
	<button>修改</button>
	<a href="/admin/tags">返回</a>
</form>

<style type="text/css">
form{
	
}
form textarea{
	border: 1px solid #ccc;
	width: 100%;
	height: 500px;
	font-size: 18px;
}
form button{
	width: 100%;
	height: 30px;
	border: none;
}
</style>

</body>
</html>