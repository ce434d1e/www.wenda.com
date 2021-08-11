{layout name="layout\layout" /}

<div class="clear"></div>

<div class="main">
	<div class="mw1024">
		<div class="wzleft">
			<div class="spm">
				<ul class="postlist" id="divMain">
					{foreach name="$lists" item="vo" key="k" }
					<li>
						<h2><a href="/ask/{$vo.post_id}.html">{$vo.post_title}</a></h2>
						<p><span>时间：{$vo.post_create_times|diyDate}</span><span>阅读：{$vo.post_view}</span><span class="iconfont">&#xe610;&nbsp;{$vo.post_comment}条回答</span>{if condition="count($vo.post_tags['list'])"}<span>
								{foreach name="$vo.post_tags['list']" item="vo2" key="k2" offset="0" length='3'}
								<a href="/ask/tags/{$vo2.tags_id}.html">{$vo2.tags_name}</a>
								{/foreach}
							</span>{/if}</p>
					</li>
					{/foreach}
				</ul>
			</div>
		</div>
		<!--右侧栏-->
		{include file="../app/ask/view/public/right.php" /}
	</div>
</div>