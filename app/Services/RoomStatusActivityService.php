<?php

namespace App\Services;

use App\Models\RoomStatusActivity;

class RoomStatusActivityService
{
    private $roomStatusActivity;

    /**
     * @return RoomStatusActivity
     */
    public function getRoomStatusActivity(): RoomStatusActivity
    {
        return $this->roomStatusActivity;
    }

    /**
     * @param RoomStatusActivity $roomStatusActivity
     */
    public function setRoomStatusActivity(RoomStatusActivity $roomStatusActivity): void
    {
        $this->roomStatusActivity = $roomStatusActivity;
    }

    public function save($userId, $roomId, $statusId)
    {
        $this->roomStatusActivity->user_id = $userId;
        $this->roomStatusActivity->room_id = $roomId;
        $this->roomStatusActivity->status_id = $statusId;
        $this->roomStatusActivity->save();

        return $this->roomStatusActivity;
    }
}
