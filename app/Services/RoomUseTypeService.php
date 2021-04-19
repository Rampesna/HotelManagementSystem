<?php

namespace App\Services;

use App\Models\RoomUseType;
use Illuminate\Http\Request;

class RoomUseTypeService
{
    private $roomUseType;

    /**
     * @return RoomUseType
     */
    public function getRoomUseType(): RoomUseType
    {
        return $this->roomUseType;
    }

    /**
     * @param RoomUseType $roomUseType
     */
    public function setRoomUseType(RoomUseType $roomUseType): void
    {
        $this->roomUseType = $roomUseType;
    }

    public function save(Request $request)
    {
        $this->roomUseType->name = $request->name;
        $this->roomUseType->short = $request->short;
        $this->roomUseType->save();

        return $this->roomUseType;
    }
}
