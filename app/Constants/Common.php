<?php 

namespace App\Constants;

class Common
{
    const PRODUCT_ADD ='1';
    const PRODUCT_REDUCE = '2';

    // クラス内で定数を使用する場合には、 self　をつけてあげないといけない
    const PRODUCT_LIST = [
        'add' => self::PRODUCT_ADD,
        'reduce' => self::PRODUCT_REDUCE
    ];
}

?>