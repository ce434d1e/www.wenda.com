{layout name="layout/layout" /}
<link rel="stylesheet" type="text/css" href="/public/ask/css/add.css">
<div class="clear"></div>
<div class="main">
    <div class="mw1024">
        <div class="wzleft">
            <div class="spm">
                <form id="form_add" method="post">
                    <p>
                        <span class="form_add_title">标题</span>
                        <input type="" value="{$post_title}" name="title">
                    </p>
                    <button>发布</button>
                </form>
            </div>
        </div>
        <!--右侧栏-->{include file="../app/ask/view/public/right.php" /}
    </div>
</div>