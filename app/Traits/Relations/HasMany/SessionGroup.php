<?php

namespace App\Traits\Relations\HasMany;

trait SessionGroup
{

    /**
     * Установление реляционной зависимости с пользователем
     *
     * @return Collection
     */
    public function session_group()
    {
        return $this->hasMany(\App\Models\SessionGroup::class);
    }

}
