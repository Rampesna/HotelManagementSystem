<?php

namespace App\Services;

use App\Models\Room;

class RoomService
{
    private $room;

    /**
     * @return mixed
     */
    public function getRoom()
    {
        return $this->room;
    }

    /**
     * @param mixed $room
     */
    public function setRoom(Room $room): void
    {
        $this->room = $room;
    }

    public function getRoomsByPanTypeAndRoomType($roomType, $panType)
    {
        return Room::where('room_type_id', $roomType)->where('pan_type_id', $panType)->get();
    }

    public function setStatus($statusId)
    {
        $this->room->room_status_id = $statusId;
        $this->room->save();
    }
}
