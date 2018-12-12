<?php
namespace app\api\validate;

use app\api\validate\BaseValidate;

class Count extends BaseValidate
{
    protected $rule = [
        'count' => 'isInteger|between:1,15'
    ];
}

?>