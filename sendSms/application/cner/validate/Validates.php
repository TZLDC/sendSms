<?php
namespace app\cner\validate;
use think\Validate;
class Validates extends Validate{
    protected $rule=[
        ['account','require','账号不能为空'],
        ['pass','require','密码不能为空'],
        ['code','require|captcha','验证码不能为空|验证码错误'],
        ['TemplateCode','require','模板Code不能为空'],
        ['Content','require','短信内容不能为空'],
    ];
    protected $scene=[
        'login'=>['account','pass','code'],
        'addsmsmess'=>['TemplateCode','Content'],
    ];
}