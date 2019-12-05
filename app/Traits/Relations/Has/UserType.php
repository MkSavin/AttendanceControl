<?php

namespace App\Traits\Relations\Has;

trait UserType
{

    /**
     * Установление реляционной зависимости с типом пользователя
     *
     * @return Collection
     */
    public function user_type()
    {
        return $this->has(\App\Models\UserType::class);
    }

}
