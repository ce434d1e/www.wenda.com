<?php
// 应用公共文件


function diyDate($timestamp){
	if(strlen($timestamp)!=10){
		$timestamp=strtotime($timestamp);
	}

    $strTime = array("秒", "分钟", "小时", "天", "月", "年");
    $length = array("60", "60", "24", "30", "12", "10");
    $currentTime = time();
    if ($currentTime >= $timestamp) {
        $diff = time() - $timestamp;
        for ($i = 0; $diff >= $length[$i] && $i < count($length) - 1; $i++) {
            $diff = $diff / $length[$i];
        }
        $diff = round($diff);
        return $diff . " " . $strTime[$i] . "前";
    }
}
