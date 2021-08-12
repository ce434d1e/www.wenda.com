<?php
namespace app\admin\controller;
use think\facade\View;
use think\facade\Db;

class Keys{
    public function index(){
        return View::fetch();
    }

    public function lists(){
        $list=Db::name("keys")->where([['keys_length','>',10],['keys_length','<',20]])->orderRaw("rand()")->limit(10)->select()->toArray();
        foreach ($list as $key => $value) {
            echo "<a target='_blank' href='/ask/add.html?title={$value['keys_name']}'>{$value['keys_name']}</a><br><br>";
        }
    }

    public function inits(){

        //获取关键词
        $keys=Db::name("keys")->order("keys_update_times asc")->limit(1)->select()->toArray();

        if(!count($keys)){
            $data=explode(",","持久,性功能");
            foreach ($data as $key => $value) {
                Db::name("keys")->save(['keys_name'=>$value]);
            }
            echo '已经成功初始化';
            $this->js_go();
            exit;
        }
        $keys=$keys[0];

        echo "当前采集关键词：{$keys['keys_name']}<br>";

        $list=$this->wd_baidu($keys['keys_name']);

        dump($list);

        //更新当前关键词采集时间
        Db::name("keys")->where(['keys_id'=>$keys['keys_id']])->save(['keys_update_times'=>time()]);

        //允许关键词
        $allow_list='生理需求,性经验,做爱,持久,早泄,阳痿,java,百度,词,知乎';
        $allow_list=array_filter(explode(',',$allow_list));
        //禁用关键词
        $prohibit_list='药,地黄丸,医生,英文,反义词';
        $prohibit_list=array_filter(explode(',',$prohibit_list));

        $new_a_list=[];
        $new_p_list=[];
        foreach ($list as $key => $value) {
            //禁用名单
            foreach ($prohibit_list as $key_p => $value_p) {
                if(strpos($value,$value_p)!==false){
                    $new_p_list[]=$value;
                }
            }

            //白名单
            foreach ($allow_list as $key_p => $value_p) {
                if(strpos($value,$value_p)!==false){
                    $new_a_list[]=$value;
                }
            }
        }

        $res_list=array_diff($new_a_list,$new_p_list);

        //写入数据库
        $n=0;
        foreach ($res_list as $key => $value) {
            //判断数据库中是否有存在
            $count=Db::name("keys")->where(['keys_name'=>$value])->count();
            if(!$count){
                $db_res=Db::name("keys")->save(['keys_name'=>$value,'keys_length'=>mb_strlen($value)]);
                if($db_res){
                    $n+=1;
                }
            }
        }
        echo "成功采集{$n}个关键词";

        foreach ($res_list as $key => $value) {
            echo "{$value}<br>";
        }

        $this->js_go();
    }
    public function curl($url){
        $client = new \GuzzleHttp\Client();
        try {
            $response = $client->request('GET',$url,[
                'verify' => false,
                'timeout' => 15,
                'read_timeout' => 15,
            ]);
            if($response->getStatusCode()!=200){
                return false;
            }
            $res=$response->getBody();
            return $res.'';
        } catch (\Exception $e) {
            return false;
        }
    }
    public function wd_baidu($keys){
        $url="https://www.baidu.com/sugrec?json=1&prod=wise&wd=".urldecode($keys);
        $res=$this->curl($url);
        if($res===false){
            return [];
        }
        $json=json_decode($res,true);

        if(empty($json['g'])){
            return [];
        }

        return array_column($json['g'],"q");
    }

    public function js_go(){
        echo '<script>location.href=location.href;</script>';
    }
}