{layout name="layout/layout" /}
<?php
$rightController = new app\ask\controller\Right;
$postRelated = $rightController->postRelated($post['post_tags']);
?>

<div class="clear"></div>

<div class="main">
	<div class="mw1024">
		<div class="wzleft">
			<div class="spm">
				<h1>{$post.post_title}</h1>
				<div class="info"><span>阅读：{$post.post_view}</span><span>时间：{$post.post_create_times|diyDate}</span> </div>
				{if condition="strlen($post.post_body)"}
				<div class="zhengwen">
					<p><span style="color: #595959;">{$post.post_body}</span></p>
				</div>
				{/if}
				{if condition="count($post.post_tags['list'])"}
				<div class="tags">
					{foreach name="post.post_tags['list']" item="vo" key="k" }
					<a href="/ask/tags/{$vo.tags_id}.html">{$vo.tags_name}</a>
					{/foreach}
				</div>
				{/if}
			</div>

			{if condition="$_SERVER['user_id']"}
			<link rel="stylesheet" type="text/css" href="/public/ask/css/add.css">
			<form id="form_add" style="padding: 0px;" method="post" action="/ask/add/comment.html">
				<input type="hidden" name="comment_post_id" value="{$post.post_id}">
				<textarea style="min-height: 200px;" name="comment_body"></textarea>
				<br>
				<br>
				<button>提交</button>
			</form>
			<br>
			{/if}
			<?php if (count($comment_list)) { ?>
				<div class="spm">
					<h3>最佳回答</h3>
					<div class="info2">
						<div class="author"><img src="{$comment_list[0]['user_img']}">
							<p class="aut">{$comment_list[0]['user_nickname']}</p>
							<p>回答于：{$comment_list[0]['comment_create_times']|diyDate}</p>
						</div>
						<div class="zjhd"><span class="iconfont">&#xe716;</span></div>
					</div>
					<div class="clear"></div>
					<div class="zhengwen"><?php echo $comment_list[0]['comment_content']; ?></div>
					<br>
				</div>
			<?php } ?>
			<?php if (count($comment_list) > 1) { ?>
				<div class="spm">
					<h3>最新回答<span>共有{:count($comment_list)}条回答</span></h3>
					<div class="comlist">
						{foreach name="$comment_list" offset="1" item="vo" key="k" }
						<ul class="{if condition='$k==0'}bordertop{/if}">
							<li>
								<img src="{$vo.user_img}">
								<div class="clbody">
									<div class="cinfo">
										<a rel="nofollow">
											<h5>{$vo.user_nickname}</h5>
										</a>
									</div>
									<em>{$vo.comment_create_times|diyDate}</em>
									<?php echo $vo['comment_content']; ?>
								</div>
							</li>
						</ul>
						{/foreach}
					</div>
				</div>
			<?php } ?>

			<div class="spm">
				<h3>相关问答</h3>
				<ul class="postlist" id="divMain">
					{foreach name="$post_tags_list" item="vo" key="k" }
					<li>
						<h2><a href="/ask/{$vo['post_id']}.html">{$vo.post_title}</a></h2>
						<p><span>
								{if condition="count($vo.post_tags['list'])"}
								{foreach name="$vo.post_tags['list']" item="vo2" key="k2" }
								<a href="/ask/tags/{$vo2.tags_id}.html" target="_blank">{$vo2.tags_name}</a>
								{/foreach}
								{/if}
							</span><span>时间：{$vo['post_create_times']|diyDate}</span><span>阅读：{$vo['post_view']}</span><span class="iconfont">&#xe610;&nbsp;{$vo['post_comment']}条回答</span></p>
					</li>
					{/foreach}
				</ul>
			</div>
		</div>
		<!--右侧栏-->
		{include file="../app/ask/view/public/right.php" /}
	</div>
</div>