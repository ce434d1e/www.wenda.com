{layout name="layout\layout" /}

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
				{if condition="count($post.post_tags_list)"}
				<div class="tags">
					{foreach name="post.post_tags_list" item="vo" key="k" }
					<a href="/ask/tags/{$vo}.html">{$vo}</a>
					{/foreach}
				</div>
				{/if}
			</div>

			{if condition="$_SERVER['user_id']"}
			<link rel="stylesheet" type="text/css" href="/public/ask/css/add.css">
			<form id="form_add" style="padding: 0px;" method="post" action="/ask/add/comment">
				<input type="hidden" name="comment_post_id" value="{$post.post_id}">
				<textarea style="min-height: 200px;" name="comment_body">夺标
所发生 栽植 
霸
所发生地
茜</textarea>
				<br>
				<br>
				<button>提交</button>
			</form>
			<br>
			{/if}
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

			<div class="spm">
				<h3>最新回答<span>共有{:count($comment_list)}条回答</span></h3>
				<div class="comlist">
					{foreach name="$comment_list" item="vo" key="k" }
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

			<div class="spm">
				<h3>最近更新</h3>
				<ul class="postlist" id="divMain">
					<li>
						<h2><span>置顶</span><a href="http://wz01.hnysnet.com/post/35.html" title="怎么做一个推广网赚项目的网站？">怎么做一个推广网赚项目的网站？</a></h2>
						<p><span><a href="http://wz01.hnysnet.com/category-2.html" title="网上赚钱方法">网上赚钱方法</a></span><span>时间：2年前</span><span>阅读：1967</span><span class="iconfont">&#xe610;&nbsp;12条回答</span></p>
					</li>
					<li>
						<h2><a href="http://wz01.hnysnet.com/post/65.html" title="1111111111">1111111111</a></h2>
						<p><span><a href="http://wz01.hnysnet.com/category-1.html" title="在家赚钱方法">在家赚钱方法</a></span><span>时间：7个月前</span><span>阅读：330</span><span class="iconfont">&#xe610;&nbsp;2条回答</span></p>
					</li>
					<li>
						<h2><a href="http://wz01.hnysnet.com/post/53.html" title="12312312312">12312312312</a></h2>
						<p><span><a href="http://wz01.hnysnet.com/category-1.html" title="在家赚钱方法">在家赚钱方法</a></span><span>时间：12个月前</span><span>阅读：450</span><span class="iconfont">&#xe610;&nbsp;3条回答</span></p>
					</li>
					<li>
						<h2><a href="http://wz01.hnysnet.com/post/44.html" title="文章中巧用H3 H4标签，显示的特殊效果">文章中巧用H3 H4标签，显示的特殊效果</a></h2>
						<p><span><a href="http://wz01.hnysnet.com/category-4.html" title="主题更新记录">主题更新记录</a></span><span>时间：2年前</span><span>阅读：944</span><span class="iconfont">&#xe610;&nbsp;1条回答</span></p>
					</li>
					<li>
						<h2><a href="http://wz01.hnysnet.com/post/43.html" title="2019年12月9日显示的内容|可以在分类列表前面显示当前分类的摘要内容">2019年12月9日显示的内容|可以在分类列表前面显示当前分类的摘要内容</a></h2>
						<p><span><a href="http://wz01.hnysnet.com/category-4.html" title="主题更新记录">主题更新记录</a></span><span>时间：2年前</span><span>阅读：698</span><span class="iconfont">&#xe610;&nbsp;0条回答</span></p>
					</li>
					<li>
						<h2><a href="http://wz01.hnysnet.com/post/40.html" title="2019年11月12日更新内容|优化了文章页图片自适应">2019年11月12日更新内容|优化了文章页图片自适应</a></h2>
						<p><span><a href="http://wz01.hnysnet.com/category-4.html" title="主题更新记录">主题更新记录</a></span><span>时间：2年前</span><span>阅读：680</span><span class="iconfont">&#xe610;&nbsp;3条回答</span></p>
					</li>
					<li>
						<h2><a href="http://wz01.hnysnet.com/post/38.html" title="测试一下这个站">测试一下这个站</a></h2>
						<p><span><a href="http://wz01.hnysnet.com/category-1.html" title="在家赚钱方法">在家赚钱方法</a></span><span>时间：2年前</span><span>阅读：853</span><span class="iconfont">&#xe610;&nbsp;2条回答</span></p>
					</li>
					<li>
						<h2><a href="http://wz01.hnysnet.com/post/37.html" title="2019年11月8日更新记录|优化主题样式、新增热门标签和自定义模块">2019年11月8日更新记录|优化主题样式、新增热门标签和自定义模块</a></h2>
						<p><span><a href="http://wz01.hnysnet.com/category-4.html" title="主题更新记录">主题更新记录</a></span><span>时间：2年前</span><span>阅读：748</span><span class="iconfont">&#xe610;&nbsp;0条回答</span></p>
					</li>
					<li>
						<h2><a href="http://wz01.hnysnet.com/post/34.html" title="2019年10月24日更新内容|新增“我要提问”模块，可以实现游客免登陆在线提问">2019年10月24日更新内容|新增“我要提问”模块，可以实现游客免登陆在线提问</a></h2>
						<p><span><a href="http://wz01.hnysnet.com/category-4.html" title="主题更新记录">主题更新记录</a></span><span>时间：2年前</span><span>阅读：581</span><span class="iconfont">&#xe610;&nbsp;0条回答</span></p>
					</li>
					<li>
						<h2><a href="http://wz01.hnysnet.com/post/36.html" title="2019年10月27日更新内容|新增了“大气蓝”主题样式">2019年10月27日更新内容|新增了“大气蓝”主题样式</a></h2>
						<p><span><a href="http://wz01.hnysnet.com/category-4.html" title="主题更新记录">主题更新记录</a></span><span>时间：2年前</span><span>阅读：622</span><span class="iconfont">&#xe610;&nbsp;0条回答</span></p>
					</li>
					<li>
						<h2><a href="http://wz01.hnysnet.com/post/26.html" title="在家如何上网找赚钱的项目？">在家如何上网找赚钱的项目？</a></h2>
						<p><span><a href="http://wz01.hnysnet.com/category-1.html" title="在家赚钱方法">在家赚钱方法</a></span><span>时间：2年前</span><span>阅读：1574</span><span class="iconfont">&#xe610;&nbsp;16条回答</span></p>
					</li>
				</ul>

				<div class="pagebar"> <a href="http://wz01.hnysnet.com/"><span class="page">‹‹</span></a>
					<span class="page now-page">1</span>
					<a href="http://wz01.hnysnet.com/page_2.html"><span class="page">2</span></a>
					<a href="http://wz01.hnysnet.com/page_3.html"><span class="page">3</span></a>
					<a href="http://wz01.hnysnet.com/page_4.html"><span class="page">4</span></a>
					<a href="http://wz01.hnysnet.com/page_2.html"><span class="page">›</span></a>
					<a href="http://wz01.hnysnet.com/page_4.html"><span class="page">››</span></a>
				</div>
			</div>
		</div>
		<!--右侧栏-->
		{include file="../app/ask/view/public/right.php" /}
	</div>
</div>