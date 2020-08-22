<?php

namespace App\Traits\Relations\HasMany;

trait User
{

    /**
     * Установление реляционной зависимости с пользователем
     *
     * @return Collection
     */
    public function user()
    {
        return $this->hasMany(\App\Models\User::class);
    }

}
