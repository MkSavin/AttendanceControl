<?php

namespace App\Traits\Relations\BelongsTo;

trait User
{

    /**
     * Установление реляционной зависимости с пользователем
     *
     * @return Collection
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    /**
     * Установление реляционной зависимости с пользователем (создатель сеанса)
     *
     * @return Collection
     */
    public function creator()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

}
