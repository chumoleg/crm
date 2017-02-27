<?php

/**
 * Yii bootstrap file.
 * Used for enhanced IDE code autocompletion.
 */
class Yii extends \yii\BaseYii
{
    /**
     * @var BaseApplication|WebApplication|ConsoleApplication the application instance
     */
    public static $app;
}

spl_autoload_register(['Yii', 'autoload'], true, true);
Yii::$classMap = include(__DIR__ . '/vendor/yiisoft/yii2/classes.php');
Yii::$container = new yii\di\Container;

///**
// * Class BaseApplication
// * Used for properties that are identical for both WebApplication and ConsoleApplication
// *
// * @property \app\components\RbacManager $authManager The auth manager for this application. Null is returned if auth manager is not configured. This property is read-only. Extended component.
// * @property \app\components\Mailer $mailer The mailer component. This property is read-only. Extended component.
// */
//abstract class BaseApplication extends yii\base\Application
//{
//}
//

/**
 * Class WebApplication
 * Include only Web application related components here
 *
 * @property \common\components\base\User $user
 * @property \yii\web\Response            $response
 * @property yii\redis\Cache              $cache
 * @property linslin\yii2\curl\Curl       $curl
 * @property yii\swiftmailer\Mailer       $mailer
 */
class WebApplication extends yii\web\Application
{
}


///**
// * Class ConsoleApplication
// * Include only Console application related components here
// *
// * @property \app\components\ConsoleUser $user The user component. This property is read-only. Extended component.
// */
//class ConsoleApplication extends yii\console\Application
//{
//}