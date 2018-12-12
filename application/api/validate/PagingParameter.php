<?php

namespace app\api\validate;

class PagingParameter extends BaseValidate
{
    protected $rule = [
        'page'=>'isInteger',
        'size'=>'isInteger'
    ];
    protected $message = [
        'page'=>'分页参数为正整数',
        'size'=>'分页参数为正整数'
    ];
}

?>