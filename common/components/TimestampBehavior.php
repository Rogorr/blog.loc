<?php
namespace common\components;

use yii\base\Behavior;
use yii\db\ActiveRecord;

class TimestampBehavior extends Behavior
{
    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_INSERT => 'setCreatedAt',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'setUpdatedAt',
        ];
    }

    public function setCreatedAt($event)
    {
        $this->owner->created_at = date('d.m.Y H:i'); 
    }

    public function setUpdatedAt($event)
    {
        $this->owner->updated_at = date('d.m.Y H:i'); 
    }
}