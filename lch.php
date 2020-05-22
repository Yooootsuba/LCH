<?php


require __DIR__ . '/vendor/autoload.php';



class LeagueClient
{

    function __construct(lockfile)
    {

    }

}



echo
'
                          _
|   _   _.  _       _    /  | o  _  ._ _|_   |_|  _  | ._   _  ._
|_ (/_ (_| (_| |_| (/_   \_ | | (/_ | | |_   | | (/_ | |_) (/_ |
            _|                                         |

';


# Load .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

# Make sure the lockfile exists
$lockfile = getenv('LOCKFILE_PATH') . '\\lockfile';
if (is_file($lockfile) == false) {
    echo 'The path is not exist or LeagueClient.exe is not in process !';
    system('pause');
    exit();
}


?>
