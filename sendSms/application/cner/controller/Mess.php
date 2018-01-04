<?php
namespace app\cner\controller;
use app\cner\model\Smsmess;

class Mess extends Common{
    public function index(){
        $res=db('smsmess')->where('delete_time','eq',0)->paginate(10);
        $this->assign('sms',$res);
        return $this->fetch();
    }
    public function add(){
        if(request()->isAjax()){
            $data=input('post.');
            $validate=validate('Validates');
            if($validate->scene('addsmsmess')->check($data)){
                $data['create_time']=time();
                $res=db('smsmess')->insert($data);
                if($res){
                    return show(1,'添加成功');
                }else{
                    return show(0,'添加失败');
                }
            }
        }
        return $this->fetch();
    }
    public function edit(){
        if(request()->isAjax()){
            $input=input('post.');
            $id=input('get.id');
            $validate=validate('Validates');
            if($validate->scene('addsmsmess')->check($input)){
                $res=db('smsmess')->where('id',$id)->update($input);
                if($res){
                    return show(1,'修改成功');
                }else{
                    return show(0,'修改失败');
                }
            }else{
                return show(0,$validate->getError());
            }
        }else{
            $id=input('get.id');
            $res=db('smsmess')->where('id',$id)->find();
            $this->assign('sms',$res);
            return $this->fetch();
        }
    }
    public function delete(){
        $id=input('get.id');
        $res=Smsmess::destroy($id);
        if($res){
            return true;
        }else{
            return show(0,'删除失败');
        }
    }
}