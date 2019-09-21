<?php

namespace App\Traits\Relations\BelongsTo;

trait UserType
{

    /**
     * Установление реляционной зависимости с типом пользователя
     *
     * @return Collection
     */
    public function user_type()
    {
        return $this->belongsTo(\App\Models\UserType::class);
    }

}
