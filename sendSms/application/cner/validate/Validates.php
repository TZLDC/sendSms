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
        ['token','require','令牌不能为空'],
        ['webname','require','网站名称不能为空'],
        ['appid','require|alpha','AppId不能为空|AppId必须为字母组成'],
        ['key','require','Key不能为空'],
        ['Signame','require','短信签名不能为空'],
        ['type','require','签名类型不能为空'],
        ['num','require','电话不能为空'],
        ['sign','require','短信签名不能为空'],
        ['TemplateCode','require','模板code不能为空'],
        ['param','require','模板变量替换信息不能为空'],
        ['url','require','网站url不能为空'],
    ];
    protected $scene=[
        'login'=>['account','pass','code'],
        'addsmsmess'=>['TemplateCode','Content'],
        'addtoken'=>['webname','appid','key','url'],
        'addsign'=>['Signame','type'],
        'checkurl'=>['num','key','appid','sign','TemplateCode','param','url'],
    ];
}