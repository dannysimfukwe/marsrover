<?php

namespace RoverChallenge;

class Direction
{
    public static $direction = ['N', 'W', 'S', 'E'];

    public static function isValid($direction)
    {
        return in_array(strtoupper($direction), self::$direction);
    }

    public static function TurnLeft($direction)
    {
        return self::Turn($direction, 1);
    }

    public static function TurnRight($direction)
    {
        return self::Turn($direction, -1);
    }

    private static function Turn($direction, $shift)
    {
        $key = array_search($direction, self::$direction);

        if ($key + $shift >= sizeof(self::$direction)) {
            return self::$direction[0];
        }
        if ($key + $shift < 0) {
            return end(self::$direction);
        }

        return self::$direction[$key + $shift];
    }
}