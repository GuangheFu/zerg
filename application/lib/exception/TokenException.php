<?php

namespace app\lib\exception;

class TokenException extends BaseException
{
    public $code = 401;
    public $msg = 'token过期';
    public $errorcode = 100001;
}

?>