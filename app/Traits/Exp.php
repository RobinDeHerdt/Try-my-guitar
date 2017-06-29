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
     * @param integer  $exp
     * @return integer  $level
     */
    protected function calculateLevel($exp)
    {
        $level = 0.2 * sqrt($exp);
        return (int)$level;
    }

    /**
     * Add exp to the specified user.
     *
     * @param \App\User  $user
     * @param integer  $awarded_exp
     * @return integer  $level
     */
    protected function addExp($user, $awarded_exp)
    {
        $exp = $user->exp;

        $exp += $awarded_exp;

        $user->exp = $exp;
        $user->save();
    }

    /**
     * Subtract exp from the specified user.
     *
     * @param \App\User  $user
     * @param integer  $awarded_exp
     * @return integer  $level
     */
    protected function subtractExp($user, $awarded_exp)
    {
        $exp = $user->exp;

        $exp -= $awarded_exp;

        $user->exp = $exp;
        $user->save();
    }
}
