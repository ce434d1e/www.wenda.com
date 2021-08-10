<?php
namespace app\admin\controller;
use think\facade\View;
use think\facade\Request;
use think\facade\Db;
use think\Validate;
use app\common\model\Tags as mTags;

class Tags{
    use \liliuwei\think\Jump;
    public function index(){
        $mTags=new mTags();
        $list = $mTags->paginate(10);
        // 获取分页显示
        $page = $list->render();
        View::assign('list', $list);
        return View::fetch();
    }

    public function add(){
        if (Request::instance()->isPost()){
            $list=array_filter(explode("\n",input("post.list")));

            $mTags=new mTags();
            $n=0;
            foreach ($list as $key => $value) {

                $data=[];
                $data['tags_name']=trim($value);

                //验证规则
                $is_string=preg_match("/^[\x{4e00}-\x{9fa5}\w]+$/u", $data['tags_name']);

                if ($is_string) {
                    //判断标签是否从在
                    $has_tags = $mTags->where(['tags_name'=>trim($data['tags_name'])])->count();

                    if(!$has_tags){
                        $mTags=new mTags();
                        $res=$mTags->save($data);

                        if($res){
                            $n+=1;
                        }
                    }
                }
            }
            $this->success("成功添加{$n}标签");
        }else{
            return View::fetch();
        }
    }

    public function edit($id){
        $mTags=new mTags();
        $tags=$mTags->where(['tags_id'=>$id])->limit(1)->select()->toArray();

        if(!count($tags)){
            return '没有这个标签';
        }

        if (Request::instance()->isPost()){
            $mTags=new mTags();
            $name=trim(input("post.list"));

            if(strlen($name)==0){
                $mTags=new mTags();
                $res=Db::name("tags")->where(['tags_id'=>$id])->delete();

                if($res){
                    $this->success("删除成功",'/admin/tags');
                }else{
                    $this->error("删除失败");
                }
            }else{
                if($tags[0]['tags_name']==$name){
                    $this->error("你并没有修改内容");
                }
                $res=$mTags->where(['tags_id'=>$id])->save(['tags_name'=>$name]);
                if($res){
                    $this->success("修改成功",'/admin/tags');
                }else{
                    $this->error("修改失败");
                }
            }

        }else{
            View::assign('tags', $tags);
            return View::fetch();
        }
    }

    public function del(){
        return View::fetch();
    }
}