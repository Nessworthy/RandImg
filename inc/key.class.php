<?php
/**
 * Key generator.
 * @author Jon la Cour
 * @license MIT License
 * @version 1.0
 */
class key {

    /**
     * Main key generator.
     * @since 1.0
     */
    protected static function _generate_key($length = 10, $amount = 1, $user_key = false, $chars = '') {
        // Create an array for key characters
        $keychars = array();
        $key = '';

        if ($chars) {
            $keychars = explode(',', $chars);
            // Free some memory
            unset($chars);
        } else {
            $keychars = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', 0, 1, 2, 3, 4, 5, 6, 7, 8, 9);
        }

        if ($user_key) {
            $ip = str_replace('.', '', $_SERVER['REMOTE_ADDR']);
            $ip = str_replace(':', '', $ip);
            // srand & rand are used here to prevent seeding mt_rand which can
            // happen when generating different types of keys
            srand($ip);
            for ($i = 0; $i < $length; ++$i) {
                $key .= $keychars[rand(0, 61)];
            }
            // Returns a key
            return $key;
        }

        if ($amount > 1) {
            $keys = array();
            // Create an array for basic keys
            $key = '';
            for ($i = 0; $i < $amount; ++$i) {//
                for ($a = 0; $a < $length; ++$a) {
                    $key .= $keychars[mt_rand(0, count($keychars) - 1)];
                }
                array_push($keys, $key);
                $key = '';
            }
            // Returns an array of keys
            return $keys;
        } else {
            for ($i = 0; $i < $length; ++$i) {
                $key .= $keychars[mt_rand(0, count($keychars) - 1)];
            }
            // Returns a key
            return $key;
        }
    }

    /**
     * Generates a key.
     * @since 1.0
     */
    public static function new_key($length = 10, $amount = 1) {
        if ($amount > 1) {
            $keys = self::_generate_key($length, $amount);
            // Returns an array of keys
            return $keys;
        } else {
            $key = self::_generate_key($length);
            // Returns a key
            return $key;
        }
    }

    /**
     * Generates a user specific key.
     * @since 1.0
     */
    public static function user_key($length = 10) {
        $key = self::_generate_key($length, 1, true);
        return $key;
    }

    /**
     * Generates a special (custom) key.
     * @since 1.0
     */
    public static function new_special_key($length = 10, $amount = 1, $chars = 'a,b,c,d,e,A,B,C,D,E,1,2,3,4,5,!,@,#,$,%') {
        if ($amount > 1) {
            $keys = self::_generate_key($length, $amount, false, $chars);
            // Returns an array of keys
            return $keys;
        } else {
            $key = self::_generate_key($length, 1, false, $chars);
            // Returns a key
            return $key;
        }
    }

    /**
     * Generates a serial.
     * @since 1.0
     */
    public static function new_serial($pre = '', $amount = 1, $segments = 7, $seglength = 4, $divider = '-') {
        // If the pre-chunk is not set than it will automatically generate one.
        if ($pre == '')
            $pre = self::_generate_key($seglength, $amount);

        if ($amount > 1) {
            $serials = array();
            for ($a = 0; $a < $amount; ++$a) {
                $serial = '';
                $serial .= $pre;
                for ($i = 0; $i < $segments; ++$i) {
                    $serial .= $divider . self::_generate_key($seglength, 1);
                }
                $serial = strtoupper($serial);
                array_push($serials, $serial);
                unset($serial);
            }
            // Returns an array of serials
            return $serials;
        } else {
            $serial = '';
            $serial .= $pre;
            for ($i = 0; $i < $segments; ++$i) {
                $serial .= $divider . self::_generate_key($seglength, $amount);
            }
            $serial = strtoupper($serial);
            // Returns a serial
            return $serial;
        }
    }

    /**
     * Generates a hex color.
     * @since 1.0
     */
    public static function hex_color($amount = 1) {
        if ($amount > 1) {
            $colors = array();
            for ($i = 0; $i < $amount; $i++) {
                $color = sprintf('#%06x', mt_rand(0, 16777215));
                array_push($colors, $color);
                $color = '';
            }
            // Returns an array of colors
            return $colors;
        } else {
            $color = sprintf('#%06x', mt_rand(0, 16777215));
            // Returns a color
            return $color;
        }
    }

}
