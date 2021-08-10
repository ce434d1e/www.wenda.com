<?php
namespace app\common\lib;

class Tags{
	public function getArticleKey($object){
		$text=$object['text'];
        $tag=explode(",",'快乐,星,快乐星球,电脑,笔记本电脑,笔记本');
        
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

        return $e;
	}
}