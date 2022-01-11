<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "account".
 *
 * @property int $id
 * @property string $name
 * @property int $status
 */
class Account extends \yii\db\ActiveRecord
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 1;

    public static $rangeStatus = [
        self::STATUS_DELETED => 'Не активен',
        self::STATUS_ACTIVE => 'Активен',
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'account';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['status'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'status' => 'Статус',
        ];
    }


    /**
     * @return Account[]|null
     */
    public static function getActiveList()
    {
        return self::find()
            ->where(['status' => 1])
            ->all();
    }
}
