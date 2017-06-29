<?php

namespace App\Traits;

use Illuminate\Support\Facades\Session;
use \App\User;

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
     * Calculate the amount of experience needed to reach the next level.
     *
     * @param integer  $current_level
     * @return integer  $level
     */
    protected function calculateCurrentLevelExp($current_level)
    {
        return pow(($current_level / 0.2), 2);
    }

    /**
     * Calculate the amount of experience needed to reach the next level.
     *
     * @param integer  $current_level
     * @return integer  $level
     */
    protected function calculateNextLevelExp($current_level)
    {
        return pow((($current_level + 1) / 0.2), 2);
    }

    /**
     * Add exp to the specified user.
     *
     * @param \App\User  $user
     * @param integer  $awarded_exp
     * @return integer  $level
     */
    protected function addExp(User $user, $awarded_exp)
    {
        $exp = $user->exp;

        $exp += $awarded_exp;

        $user->exp = $exp;
        $user->save();

        Session::flash('exp-message', '+ ' . $awarded_exp . ' exp');
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
