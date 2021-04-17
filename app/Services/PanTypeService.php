<?php

namespace App\Services;

use App\Models\PanType;
use Illuminate\Http\Request;

class PanTypeService
{
    private $panType;

    /**
     * @return mixed
     */
    public function getPanType()
    {
        return $this->panType;
    }

    /**
     * @param mixed $panType
     */
    public function setPanType(PanType $panType): void
    {
        $this->panType = $panType;
    }

    public function save(Request $request)
    {
        $this->panType->name = $request->name;
        $this->panType->save();

        return $this->panType;
    }

    public function getPanTypesByKeyword($keyword)
    {
        return PanType::where('name', 'like', '%' . $keyword . '%')->get();
    }
}
