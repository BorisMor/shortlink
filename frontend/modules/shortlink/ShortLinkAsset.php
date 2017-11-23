<?php
/**
 * Created by PhpStorm.
 * User: Boris
 * Date: 22.11.2017
 * Time: 12:10
 */

namespace app\modules\shortlink;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class ShortLinkAsset extends AssetBundle
{
    public $sourcePath = '@frontend/modules/shortlink/assets';
    public $css = [
        'shortlink.css'
    ];
    public $js = [
        'vue/vue.js',
        'vue/vue-resource.min.js',
        'main_shortlink.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
