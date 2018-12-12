<?php

namespace app\lib\exception;

class ForbiddenException extends BaseException
{
    public $code = 403;
    public $msg = '权限不够';
    public $errorcode = 10001; 
}

?>