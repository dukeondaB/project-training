<?php
namespace App\Helpers;
function saveAvatar($studentData, $avatarData)
{
    if (isset($avatarData['avatar'])) {
        $studentData['avatar'] = $avatarData['avatar'];
    }

    return $studentData;
}
