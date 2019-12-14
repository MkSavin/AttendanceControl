<?php

namespace App\Traits\Relations\BelongsTo;

trait Right
{

    /**
     * Установление реляционной зависимости с правом
     *
     * @return Collection
     */
    public function right()
    {
        return $this->belongsTo(\App\Models\Right::class);
    }

}
