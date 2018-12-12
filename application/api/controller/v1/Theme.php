<?php
namespace app\api\controller\v1;

use app\api\validate\IDCollection;
use app\api\model\Theme as ThemeModel;
use app\lib\exception\ThemeException;
use app\api\validate\IDMustBePositiveInt;

class Theme
{
    public function getSimpleList($ids=''){
        (new IDCollection())->goCheck();
        
        $ids = explode(',',$ids);
        $reuslt = ThemeModel::getThemeList($ids);
        if($reuslt->isEmpty()){
            throw new ThemeException();
        }
        return $reuslt;
    }

    public function getComplexOne($id){
        (new IDMustBePositiveInt())->goCheck();
        $result = ThemeModel::getThemeWithProducts($id);
        if($result->isEmpty()){
            throw new ThemeException();
        }
        return $result;
    }
}
?>