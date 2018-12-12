<?php
namespace app\lib\exception;

use app\lib\exception\BaseException;


class ParameterException extends BaseException
{
    public $code = 400;
    public $msg = '参数错误';
    public $errorcode = 10000;


}
?>