<?php

namespace App\Traits;

/**
 * Trait Exp
 * @package App\Traits
 */
trait Exp
{
    /**
     * Calculate the level for the specified exp.
     *
     * @return integer  $level
     */
    protected function calculateLevel($exp)
    {
        $level = 0.2 * sqrt($exp);

        return (int)$level;
    }
}
