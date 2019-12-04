<?php

namespace App\Traits\Relations\HasMany;

trait Attendance
{

    /**
     * Установление реляционной зависимости с пользователем
     *
     * @return Collection
     */
    public function attendance()
    {
        return $this->hasMany(\App\Models\Attendance::class);
    }

}
