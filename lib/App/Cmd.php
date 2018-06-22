<?php

namespace App;

use App\Log;
use Exception;

/**
* Utilities
*/
class Cmd
{
    

    public static function doCmd($cmd, $cwd=null, $env=null, $allow_exception=false) {
        try {
            $old_cwd = null;
            if ($cwd !== null) {
                $old_cwd = getcwd();
                chdir($cwd);
            }


            $debug_env = '';
            if ($env !== null) {
                foreach($env as $key => $val) {
                    $env_entry = "{$key}={$val}";
                    putenv($env_entry);
                    $debug_env = ltrim($debug_env." ".$env_entry);
                }
            }

            Log::wlog(($cwd ? '['.$cwd.' #]' : '#').rtrim(' '.$debug_env).' '.$cmd);

            $return = array();
            exec($cmd, $return, $return_code);
            $output = join("\n",$return);
            if (strlen($output)) { Log::wlog($output); }

            if ($old_cwd !== null AND strlen($old_cwd)) { chdir($old_cwd); }

            // clear env
            if ($env !== null) { foreach($env as $key => $val) { putenv($key); }; }

            if ($return_code) { throw new Exception("Command failed with code $return_code".(strlen(trim($output)) > 0 ? "\n".$output : ''), $return_code); }

            return $output;
        } catch (Exception $e) {
            if ($allow_exception) {
                Log::wlog("Error: ".$e->getMessage());
                return null;
            }
            throw $e;
        }
    }


}
