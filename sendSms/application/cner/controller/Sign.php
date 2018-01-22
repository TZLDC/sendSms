<?php
namespace app\cner\controller;
class Sign extends Common{
    public function index(){
        $res=db('sign')->where('delete_time','eq',0)->select();
        $this->assign('sms',$res);
        return $this->fetch();
    }
    public function add(){
        if(request()->isAjax()){
            $data=input('post.');
            $validate=validate('Validates');
            if($validate->scene('addsign')->check($data)){
                $res=db('sign')->insert($data);
                if($res){
                    return show(1,'添加成功');
                }else{
                    return show(0,'添加失败');
                }
            } else{
                return show(0,$validate->getError());
            }
        }else{
            return $this->fetch();
        }
    }
    public function edit(){
        if(request()->isAjax()){
            $data=input('post.');
            $id=input('get.id');
            $validate=validate('Validates');
            if($validate->scene('addsign')->check($data)){
                $res=db('sign')->where('id',$id)->update($data);
                if($res){
                    return show(1,'修改成功');
                }else{
                    return show(0,'修改失败');
                }
            }else{
                return show(0,$validate->getError());
            }
        }
        $id=input('get.id');
        $res=db('sign')->where('id',$id)->find();
        $this->assign('s',$res);
        return $this->fetch();
    }
    public function delete(){
        $id=input('get.id');
        $res=db('sign')->where('id',$id)->update(['delete_time'=>time()]);
        if($res){
            return true;
        }else{
            return show(0,'删除失败');
        }
    }
}