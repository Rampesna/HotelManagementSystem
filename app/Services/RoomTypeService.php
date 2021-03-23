<?php

namespace App\Services;

use App\Models\RoomType;

class RoomTypeService
{
    private $roomType;

    /**
     * @return mixed
     */
    public function getRoomType()
    {
        return $this->roomType;
    }

    /**
     * @param mixed $roomType
     */
    public function setRoomType(RoomType $roomType): void
    {
        $this->roomType = $roomType;
    }

    public function getRoomTypesByKeyword($keyword)
    {
        return RoomType::where('name', 'like', '%' . $keyword . '%')->get();
    }
}
