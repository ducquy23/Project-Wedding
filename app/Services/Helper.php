<?php

namespace App\Services;

use App\Models\WebConfig;

class Helper
{
    public function getConfig()
    {
        return WebConfig::query()->find(1);
    }

    public function showUserAvatar($object, $class = '', $id = '', $attr = '')
    {
        if (empty($object) || empty($object->avatar)) {
            return '<img id="' . $id . '" class="' . $class . '" src="/images/no-image.png" alt="' . $object->name . '" title="' . $object->name . '" ' . $attr . ' />';
        }
        return '<img id="' . $id . '" class="' . $class . '" src="' . $object->avatar . '" alt="' . $object->name . '" title="' . $object->name . '" ' . $attr . '/>';

    }

}
