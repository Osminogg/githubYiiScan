<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\models\Account;
use app\models\Repository;
use app\models\Scanner;
use app\models\User;
use yii\console\Controller;
use yii\console\ExitCode;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class HelloController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */
    public function actionIndex($message = 'hello world')
    {
        echo $message . "\n";

        return ExitCode::OK;
    }

    public function actionScan()
    {
        $repositories = [];
        $accounts = Account::getActiveList();
        //сканирование github
        try {
            foreach ($accounts as $account)
            {
                $result = Scanner::start($account->name);
                $repositories = array_merge($repositories, $result);
            }
        } catch (\Exception $e) {
            echo 'Ошибка: ',  $e->getMessage(), "\n";
        }
        //сортировка
        usort($repositories, function($a, $b) {
            return strtotime($b['updated_at']) - strtotime($a['updated_at']);

        });
        $repositories = array_slice($repositories, 0, 10);
        //сохранение
        Repository::saveArray($repositories, $accounts);
    }

    public function actionAddAdmin() {
        $model = User::find()->where(['username' => 'admin'])->one();
        if (empty($model)) {
            $user = new User();
            $user->username = 'admin';
            $user->email = 'admin@mail.ru';
            $user->setPassword('1234');
            $user->generateAuthKey();
            if ($user->save()) {
                echo 'good';
            }
        }
    }
}
