<?php

namespace App\Traits\Models\Attributes;

use App\Helpers;

trait ActiveAt {

    /**
     * Аксессор. Дата и время активности
     *
     * @return string
     */
    public function getActiveDateTimeAttribute()
    {
        return Helpers\DateTime::CarbonForRelativeHuman($this->active_at);
    }

    /**
     * Аксессор. Дата активности
     *
     * @return string
     */
    public function getActiveDateAttribute()
    {
        return Helpers\DateTime::CarbonRelative($this->active_at);
    }

    /**
     * Аксессор. Время активности. Имеет свой формат задания названия
     *
     * @return string
     */
    public function getActiveAtTimeAttribute()
    {
        return $this->active_at ? $this->active_at->format('H:i:s') : "";
    }

    /**
     * Аксессор. Timestamp даты активности
     *
     * @return string
     */
    public function getActiveTimestampAttribute()
    {
        return $this->active_at ? $this->active_at->timestamp : "";
    }
    
}