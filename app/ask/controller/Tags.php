<?php
namespace app\ask\controller;
use think\facade\View;
use app\common\model\Post as mPost;
use app\common\model\Tags as mTags;
use app\ask\controller\Index as cIndex;

class Tags{
    public function index($id){
        
        $mTags=new mTags();
        $tags=$mTags->where(['tags_id'=>$id])->limit(1)->select()->toArray();

        if(!count($tags)){
            $cIndex=new cIndex();
            return $cIndex->postRan();
        }
        $mPost=new mPost();
        $lists=$mPost->where([['post_title','like',"%".$tags[0]['tags_name']."%"]])->limit(10)->select()->toArray();

        View::assign([
            'tags'=>$tags[0],
            'lists'  => $lists,
            'title'=>"关于{$tags[0]['tags_name']}的所有问答 - ".config("seo.name"),
            'keywords'=>$tags[0]['tags_name'],
        ]);

        return view('ask@index/index');
    }
}