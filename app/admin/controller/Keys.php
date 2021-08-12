<?php
namespace app\admin\controller;
use think\facade\View;
use think\facade\Db;
use think\facade\Request;

class Keys{
    public function index(){
        return View::fetch();
    }

    public function lists(){
        $list=Db::name("keys")->where([['keys_length','>',10],['keys_length','<',20],['keys_status','=',0]])->orderRaw("rand()")->limit(100)->select()->toArray();
        foreach ($list as $key => $value) {
            echo "<a href='/admin/keys/del?keys_id={$value['keys_id']}'>删除</a>&nbsp;&nbsp;&nbsp;&nbsp;<a target='_blank' href='/ask/add.html?title={$value['keys_name']}'>{$value['keys_name']}</a><br><br>";
        }
    }

    //允许词
    public function allow(){
        if (Request::instance()->isPost()){
            $add=input("post.add");
            if($add){
                //判断是否有这个关键词
                $count=Db::name("keys_ci")->where(['kc_name'=>$add])->count();
                if(!$count){
                    $res=Db::name("keys_ci")->save(['kc_name'=>$add,'kc_type'=>1]);
                }
                $this->updateKeysKc();
                return header("location:/admin/keys/allow");
            }else{
                echo '错误';
            }
        }else{
            $search=input("get.search",'');
            if($search){
                $where=['kc_name'=>$search];
            }else{
                $where=[];
            }

            $list=Db::name("keys_ci")->where(['kc_type'=>1])->where($where)->select()->toArray();
            View::assign('list', $list);
            return View::fetch();
        }
    }//禁用词
    public function prohibit(){
        if (Request::instance()->isPost()){
            $add=input("post.add");
            if($add){
                //判断是否有这个关键词
                $count=Db::name("keys_ci")->where(['kc_name'=>$add])->count();
                if(!$count){
                    $res=Db::name("keys_ci")->save(['kc_name'=>$add,'kc_type'=>2]);
                    //删除数据库中所有的带此关键词的数据
                    Db::name("keys")->where([['keys_name','like',"%{$add}%"]])->delete();
                }
                $this->updateKeysKc();
                return header("location:/admin/keys/prohibit");
            }else{
                echo '错误';
            }
        }else{
            $search=input("get.search",'');
            if($search){
                $where=['kc_name'=>$search];
            }else{
                $where=[];
            }

            $list=Db::name("keys_ci")->where(['kc_type'=>2])->where($where)->select()->toArray();
            View::assign('list', $list);
            return View::fetch();
        }
    }

    public function updateKeysKc(){
        $allow_list=Db::name("keys_ci")->where(['kc_type'=>1])->select()->toArray();
        $prohibit_list=Db::name("keys_ci")->where(['kc_type'=>2])->select()->toArray();
        $allow_list_new=array_column($allow_list,"kc_name");
        $prohibit_list_new=array_column($prohibit_list,"kc_name");
        
        cache("allow_list",$allow_list_new);
        cache("prohibit_list",$prohibit_list_new);
    }

    public function id($id){
        $delete=input("get.delete");
        $type=input("get.type");
        if($delete=='1'){
            $res=Db::name("keys_ci")->where(['kc_id'=>$id])->delete();
            if($res){
                if($type=='1'){
                    $u='/admin/keys/allow';
                }
                if($type=='2'){
                    $u='/admin/keys/prohibit';
                }
                $this->updateKeysKc();
                header("location:".$u);
            }else{
                echo '删除失败';
            }
        }else{
            $ck=Db::name("keys_ci")->where(['kc_id'=>$id])->select()->toArray();
            if(!count($ck)){
                echo '关键词不存在';
                exit;
            }
            echo "当前关键词：{$ck[0]['kc_name']}";
            echo "<br><br>";
            echo "<a href='/admin/keys/{$id}.html?delete=1&type={$ck[0]['kc_type']}'>删除关键词</a>";
        }
    }

    //删除keys表中的词
    public function del(){
        $id=input("get.keys_id");
        if($id=='all'){
            $is=input("get.is");
            if($is==1){
                Db::name("keys")->where([['keys_id','>',0]])->delete();
                header("location:/admin/keys");
            }else{
                echo '<a href="/admin/keys/del?keys_id=all&is=1">确认要删除所有数据</a>';
            }
        }else{
            Db::name("keys")->where(['keys_id'=>$id])->save(['keys_status'=>7]);
            header("location:/admin/keys/lists");
        }
        
    }

    public function inits(){
        //获取关键词
        $keys=Db::name("keys")->order("keys_update_times asc")->limit(1)->select()->toArray();

        //允许关键词
        $allow_list=cache("allow_list")?:[];
        $allow_list=array_filter($allow_list);

        if(!count($keys)){
            $data=$allow_list;
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

        
        //禁用关键词
        $prohibit_list=cache("prohibit_list")?:[];
        $prohibit_list=array_filter($prohibit_list);

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
        echo '<script>setTimeout(function(){location.href=location.href;},1000)</script>';
    }
}