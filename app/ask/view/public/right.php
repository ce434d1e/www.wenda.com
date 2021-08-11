<?php
$rightController = new app\ask\controller\Right;
$tagsRand = $rightController->tagsRand();
$postRand_1 = $rightController->postRand();
$postRand_2 = $rightController->postRand();
$postRand_3 = $rightController->postRand();
?>

<div class="wz-r mt15 ">
	<div class="wzright">
		<div class="spm">
			<h3>推荐问答</h3>
			<ul>
				{foreach name="$postRand_1" item="vo" key="k" }<li><a href="/ask/{$vo.post_id}.html">{$vo.post_title}</a><span>{$vo.post_comment}条回答</span></li>{/foreach}
			</ul>
		</div>
		<div class="spm">
			<h3>热门问答</h3>
			<ul>
				{foreach name="$postRand_1" item="vo" key="k" }<li><a href="/ask/{$vo.post_id}.html">{$vo.post_title}</a><span>{$vo.post_comment}条回答</span></li>{/foreach}
			</ul>
		</div>
		<div class="spm">
			<h3>随机问答</h3>
			<ul>
				{foreach name="$postRand_1" item="vo" key="k" }<li><a href="/ask/{$vo.post_id}.html">{$vo.post_title}</a><span>{$vo.post_comment}条回答</span></li>{/foreach}
			</ul>
		</div>


		<div class="spm">
			<h3>热门标签</h3>
			<ul class="hottags">
				{foreach name="$tagsRand" item="vo" key="k" }
				<li><a target="_blank" href="/ask/tags/{$vo.tags_id}.html">{$vo.tags_name}</a></li>
				{/foreach}
			</ul>
			<div class="clear"></div>
		</div>

		{/*

		<!-- <div class="spm">
  <h3>关注我们</h3>
  <div class="qrcode"><img src="" alt="qrcode"> <p>扫一扫二维码关注我们的微信公众号</p></div>
</div> -->

		*/}
	</div>
</div>