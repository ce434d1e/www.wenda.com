<?php
namespace app\ask\controller;
use think\facade\View;
use app\common\model\Post as mPost;
use app\common\model\Tags as mTags;
use app\common\lib\Tags as lTags;

class Right{
    //随机标签
    public function tagsRand(){
        $mTags=new mTags();
        $list=$mTags->where([['tags_post_count','>=',1]])->limit(30)->select()->toArray();
        return $list;
    }
    //随机文章
    public function postRand(){
        $mPost=new mPost();
        $list=$mPost->where(['post_status'=>1])->orderRaw('rand()')->limit(10)->select()->toArray();
        return $list;
    }
    //相关文章
    public function postRelated($tags){

        $tags_list=array_column($tags['list'],'tags_name');
        $data=[];
        foreach ($tags_list as $key => $value) {
            $data[]=['post_title','like',"%{$value}%"];
        }

        $mPost=new mPost();

        $list=$mPost->where(['post_status'=>1])->whereOr($data)->limit(10)->select()->toArray();

        return $list;
    }
}