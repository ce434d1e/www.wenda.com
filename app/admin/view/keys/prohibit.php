<h2>禁用词</h2>

<a href="/admin/keys">返回列表</a><br><br>

<form method="post">
	<input type="text" name="add">
	<button>添加禁止词</button>
</form>

<form method="get">
	<input type="text" name="search">
	<button>搜索</button>
</form>

{volist name="list" id="vo"}
<a href="/admin/keys/{$vo.kc_id}.html">{$vo.kc_name}</a>
{/volist}