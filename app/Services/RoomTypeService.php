<?php

namespace App\Services;

use App\Models\RoomType;
use Illuminate\Http\Request;

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

    public function save(Request $request)
    {
        $this->roomType->name = $request->name;
        $this->roomType->save();

        return $this->roomType;
    }

    public function getRoomTypesByKeyword($keyword)
    {
        return RoomType::where('name', 'like', '%' . $keyword . '%')->get();
    }
}
