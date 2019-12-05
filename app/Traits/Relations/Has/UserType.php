<?php

namespace App\Traits\Relations\Has;

trait UserType
{

    /**
     * Установление реляционной зависимости с пользователем
     *
     * @return Collection
     */
    public function user_type()
    {
        return $this->has(\App\Models\UserType::class);
    }

}
