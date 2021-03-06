<?php
namespace app\common\model;
use think\Model;

class Category extends Model{
    protected $autoWriteTimestamp=true;//开启自动写入时间戳

    public function add($data){
        $data['status']=1;
        // $data['create_time']=time();
        return $this->save($data);
    }

    // 获取一级栏目
    public function getNomalFirstCategory(){
        $data=[
            'status'=>1,
            'parent_id'=>0
        ];

        $order=[
            'id'=>'desc'
        ];

        return $this->where($data)
            ->order($order)
            ->select();
    }

    public function getFirstCategorys($parentId=0){
        $data=[
            'parent_id'=>$parentId,
            'status'=>['neq',-1]
        ];

        $order=[
            'listorder'=>'asc'
        ];

        $result=$this->where($data)
            ->order($order)
            // ->select();
            ->paginate();

        // echo $this->getLastSql();

        return $result;
    }

    // 通过parentId查询二级分类
    public function getNormalCategoryByParentId($parentId=0){
        $data=[
            'status'=>1,
            'parent_id'=>$parentId,
        ];

        $order=[
            'id'=>'desc',
        ];

        return $this->where($data)
            ->order($order)
            ->select();
    }


    // 状态-获取器
    public function getStatusAttr($value)
    {
        $status = [
            -1=>'<span class="label label-danger radius">删除</span>',
            0=>'<span class="label label-danger radius">待审</span>',
            1=>'<span class="label label-success radius">正常</span>',
        ];
        return $status[$value];
    }
}
