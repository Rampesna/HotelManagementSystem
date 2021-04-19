<?php

namespace App\Services;

use App\Models\Extra;
use Illuminate\Http\Request;

class ExtraService
{
    private $extra;

    /**
     * @return Extra
     */
    public function getExtra(): Extra
    {
        return $this->extra;
    }

    /**
     * @param Extra $extra
     */
    public function setExtra(Extra $extra): void
    {
        $this->extra = $extra;
    }

    public function save(Request $request)
    {
        $this->extra->name = $request->name;
        $this->extra->save();

        return $this->extra;
    }
}
