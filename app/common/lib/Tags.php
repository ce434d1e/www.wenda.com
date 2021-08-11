<?php
namespace app\common\lib;
use app\common\model\Tags as mTags;

class Tags{

    //给一个标题 返回数据库中的Id结果
	public function getArticleTags($object){
		$text=$object['text'];
        $keys_list=cache("tags_list_db");

        if(!$keys_list){
            $mTags=new mTags();
            $tags_list_all=$mTags->select()->toArray();
            cache("tags_list_db",$tags_list_all);
            if(count($keys_list)==0){
                return [];
            }else{
                $keys_list=$tags_list_all;
            }
        }

        $tag=[];
        foreach ($keys_list as $key => $value) {
            $tag[]=$value['tags_name'];
        }

        $in_list=[];
        foreach ($tag as $key => $value) {
            if(strpos($text,$value)!==false){
                $in_list[]=$value;
            }
        }

        //去除相同的
        $new_list=[];
        foreach ($in_list as $key => $value) {
            foreach ($in_list as $key2 => $value2) {
                if($value2!=$value && strpos($value,$value2)!==false){
                    $new_list[]=$value2;
                }
            }
        }

        $new_list=array_unique($new_list);

        $e=array_diff($in_list,$new_list);

        //获取到ID
        $id_list=[];
        foreach ($e as $key => $value) {
            foreach ($keys_list as $key2 => $value2) {
                if($value==$value2['tags_name']){
                    $id_list[]=$value2['tags_id'];
                }
            }
        }

        return implode(",",$id_list);
	}
    //给一个tag列表返回结果
    public function getTagsLis($tags){
        $tags=array_filter(explode(",",$tags));
        $keys_list=cache("tags_list_db");

        if(!$keys_list){
            $mTags=new mTags();
            $tags_list_all=$mTags->select()->toArray();
            cache("tags_list_db",$tags_list_all);
            if(count($tags_list_all)==0){
                return [];
            }else{
                $keys_list=$tags_list_all;
            }
        }

        $array=[];
        foreach ($tags as $key => $value) {
            foreach ($keys_list as $key2 => $value2) {
                if($value==$value2['tags_id']){
                    $array[]=$value2;
                }
            }
        }
        
        return $array;
    }
}