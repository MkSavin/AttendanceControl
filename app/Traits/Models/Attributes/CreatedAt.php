<?php

namespace App\Traits\Models\Attributes;

use App\Helpers;

trait CreatedAt {

    /**
     * Аксессор. Дата и время создания
     *
     * @return string
     */
    public function getCreatedDateTimeAttribute()
    {
        return Helpers\DateTime::CarbonForRelativeHuman($this->created_at);
    }

    /**
     * Аксессор. Дата создания
     *
     * @return string
     */
    public function getCreatedDateAttribute()
    {
        return Helpers\DateTime::CarbonRelative($this->created_at);
    }

    /**
     * Аксессор. Время создания
     *
     * @return string
     */
    public function getCreatedTimeAttribute()
    {
        return $this->created_at ? $this->created_at->format('H:i:s') : "";
    }

    /**
     * Аксессор. Timestamp даты создания
     *
     * @return string
     */
    public function getCreatedTimestampAttribute()
    {
        return $this->created_at ? $this->created_at->timestamp : "";
    }
    
}