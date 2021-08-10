<?php
namespace app\common\model;
use app\common\model\Model;
use app\common\model\Post as mPost;
use think\facade\Db;

class Tags extends Model{
	//表名称
	protected $name = 'tags';
	//表的主键
	protected $pk = 'tags_id';

}