<?php
namespace app\cner\controller;
class Index extends Common{
    public function index(){
        return $this->fetch();
    }
    public function welcome(){
        return $this->fetch();
    }
    public function loginout(){
        session(null);
        $this->redirect('Login/index');
    }
}