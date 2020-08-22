<?php

namespace App\Traits\Relations\BelongsTo;

trait Session
{

    /**
     * Установление реляционной зависимости с сеансом
     *
     * @return Collection
     */
    public function session()
    {
        return $this->belongsTo(\App\Models\Session::class);
    }

}
