<?php

namespace App\Services;

use App\Models\Reservation;
use App\Models\Room;
use App\Models\RoomStatusActivity;
use Illuminate\Http\Request;

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

    public function save(Request $request)
    {
        $this->room->room_status_id = $request->room_status_id;
        $this->room->room_type_id = $request->room_type_id;
        $this->room->pan_type_id = $request->pan_type_id;
        $this->room->bad_type_id = $request->bad_type_id;
        $this->room->number = $request->number;
        $this->room->person_count = $request->person_count;
        $this->room->price = $request->price;
        $this->room->save();

        return $this->room;
    }

    public function getRoomsByPanTypeAndRoomType($roomType, $panType)
    {
        return Room::where('room_type_id', $roomType)->where('pan_type_id', $panType)->get();
    }

    public function getRoomsByParameters($roomType, $panType, $startDate, $endDate, $reservationId)
    {
        $reservationRooms = Reservation::
            where(function ($dates) use ($startDate, $endDate) {
                $dates->where(function ($forStartDate) use ($startDate, $endDate) {
                    $forStartDate->where('start_date', '<=', $startDate)->where('end_date', '>=', $startDate);
                })->
                orWhere(function ($forEndDate) use ($startDate, $endDate) {
                    $forEndDate->where('start_date', '<=', $endDate)->where('end_date', '>=', $endDate);
                })->
                orWhere(function ($between) use ($startDate, $endDate) {
                    $between->where('start_date', '>=', $startDate)->where('end_date', '<=', $endDate);
                });
            })->
            where('id', '<>', $reservationId)->
            whereIn('status_id', [1, 2, 4])->
            pluck('room_id') ?? [];

        return Room::where('room_type_id', $roomType)->where('pan_type_id', $panType)->whereIn('room_status_id', [1, 2])->whereNotIn('id', $reservationRooms)->get();
    }

    public function setStatus($statusId)
    {
        $this->room->room_status_id = $statusId;
        $this->room->save();

        $roomStatusActivityService = new RoomStatusActivityService;
        $roomStatusActivityService->setRoomStatusActivity(new RoomStatusActivity);
        $roomStatusActivityService->save(auth()->user()->id(), $this->room->id, $statusId);
    }

    public function setPrice($price)
    {
        $this->room->price = $price;
        $this->room->save();
    }
}
