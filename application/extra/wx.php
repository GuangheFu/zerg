<?php

return [
    'app_id' => 'wx0f409e88e746eee2',
    'app_secret' => '3ff965db3c7d0cd69f85c767d49b5827',
    'login_url' => 'https://api.weixin.qq.com/sns/jscode2session?appid=%s&secret=%s&js_code=%s&grant_type=authorization_code',
    'access_token_url' => "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=%s&secret=%s",
];

?>