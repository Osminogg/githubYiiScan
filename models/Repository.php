<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "repository".
 *
 * @property int $id
 * @property int $account_id
 * @property string $name
 * @property int $updated_at
 */
class Repository extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'repository';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['account_id', 'name', 'updated_at'], 'required'],
            [['account_id', 'updated_at'], 'integer'],
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
            'account_id' => 'Аккаунт',
            'name' => 'Репозиторий',
            'updated_at' => 'Обновлен',
        ];
    }

    public function getAccount()
    {
        return $this->hasOne(Account::className(), ['id' => 'account_id']);
    }

    public static function saveArray($array, $accounts)
    {
        Repository::deleteAll();
        $accountNames = ArrayHelper::map($accounts, 'id', 'name');

        foreach ($array as $item)
        {
            Repository::saveModel(
                array_search($item['owner']['login'], $accountNames),
                $item['full_name'],
                strtotime($item['updated_at'])
            );
        }
    }

    public static function saveModel($account_id, $name, $updated_at)
    {
        $model = new self();
        $model->account_id = $account_id;
        $model->name = $name;
        $model->updated_at = $updated_at;

        return $model->save();
    }
}
