<?php

namespace common\components;

use common\models\user\User;

class Role
{
    const ADMIN = 'ADMIN';
    const OPERATOR = 'OPERATOR';
    const WAREHOUSE_MANAGER = 'WAREHOUSE_MANAGER';

    public static $rolesList
        = [
            self::OPERATOR          => 'Оператор call-центра',
            self::WAREHOUSE_MANAGER => 'Сотрудник склада',
            self::ADMIN             => 'Администратор',
        ];

    /**
     * @param User   $user
     * @param string $role
     */
    public static function assignRoleForUser(User $user, $role = self::OPERATOR)
    {
        $authManager = \Yii::$app->authManager;
        $role = $authManager->getRole($role);
        if ($role) {
            $authManager->assign($role, $user->getId());
        }
    }

    /**
     * @param User   $user
     * @param string $role
     */
    public static function revokeRoleForUser(User $user, $role = self::OPERATOR)
    {
        $authManager = \Yii::$app->authManager;
        $role = $authManager->getRole($role);
        if ($role) {
            $authManager->revoke($role, $user->getId());
        }
    }
}
