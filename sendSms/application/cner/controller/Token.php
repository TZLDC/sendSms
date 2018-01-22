<?php
namespace app\cner\controller;
use app\cner\model\Passmess;
class Token extends Common{
    public function index(){
        $res=db('passmess')->where('delete_time','eq',0)->paginate(10);
        $this->assign('sms',$res);
        return $this->fetch();
    }
    public function edit(){
        if(request()->isAjax()){
            $data=input('post.');
            $id=input('get.id');
            $validate=validate('Validates');
            if($validate->scene('addtoken')->check($data)){
                 $res=db('passmess')->where('id',$id)->update($data);
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
        $res=db('passmess')->where('id',$id)->find();
        $this->assign('t',$res);
        return $this->fetch();
    }
    public function add(){
        if(request()->isAjax()){
            $data=input('post.');
            $validate=validate('Validates');
            $data['create_time']=time();
            if($validate->scene('addtoken')->check($data)){
                    $res=db('passmess')->insert($data);
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
    public function getKey(){
        $key=createRandomStr(15);
        return show(1,$key);
    }
    public function delete(){
        $id=input('get.id');
        $res=Passmess::destroy($id);
        if($res){
            return true;
        }else{
            return show(0,'删除失败');
        }
    }
}