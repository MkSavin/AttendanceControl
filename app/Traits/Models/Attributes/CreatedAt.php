<?php

namespace App\Traits\Models\Attributes;

use App\Helpers;

trait CreatedAt {

    public function getCreatedAttribute()
    {
        return Helpers\DateTime::CarbonForRelativeHuman($this->created_at);
    }

    public function getCreatedDateAttribute()
    {
        return Helpers\DateTime::CarbonRelative($this->created_at);
    }

    public function getCreatedTimeAttribute()
    {
        return $this->created_at ? $this->created_at->format('H:i:s') : "";
    }

    public function getCreatedTimestampAttribute()
    {
        return $this->created_at ? $this->created_at->timestamp : "";
    }
    
}