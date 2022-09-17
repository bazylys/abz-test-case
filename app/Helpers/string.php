<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

if (! function_exists('unique_random')) {
    /**
     *
     * Generate a unique random string of characters
     * uses str_random() helper for generating the random string
     *
     * @param     $table - name of the table
     * @param     $col - name of the column that needs to be tested
     * @param  int  $chars - length of the random string
     *
     * @return string
     */
    function unique_random($table, $col, int $chars = 16): string
    {

        $notUnique = true;

        // Store tested results in array to not test them again
        $tested = [];

        do {
            $random = Str::random($chars);

            if (in_array($random, $tested)) {
                continue;
            }

            $notUnique = DB::table($table)->where($col, '=', $random)->exists();

            $tested[] = $random;
        } while ($notUnique);

        return $random;
    }

}
