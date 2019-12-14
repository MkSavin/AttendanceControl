<?php

namespace App\Traits\Relations\HasMany;

trait TypeRight
{

    /**
     * Установление реляционной зависимости с типом и группой
     *
     * @return Collection
     */
    public function type_right()
    {
        return $this->hasMany(\App\Models\TypeRight::class);
    }

}
