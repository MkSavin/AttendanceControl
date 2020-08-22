<?php

namespace App\Traits\Relations\BelongsTo;

trait Group
{

    /**
     * Установление реляционной зависимости с группой
     *
     * @return Collection
     */
    public function group()
    {
        return $this->belongsTo(\App\Models\Group::class);
    }

}
