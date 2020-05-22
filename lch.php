<?php


require __DIR__ . '/vendor/autoload.php';


class LeagueClient
{

    function __construct($lockfile)
    {
        # Get lockfile data
        $file = fopen($lockfile, 'r');
        $data = explode(':', fgets($file));
        fclose($file);

        # $data
        # (
        #     [0] => 'LeagueClient'
        #     [1] =>  I don't know
        #     [2] =>  Port number
        #     [3] =>  Authorization token
        #     [4] =>  Connecton method
        # )

        $this->host              = '127.0.0.1';
        $this->port              =  $data[2];
        $this->connection_method =  $data[4];
        $this->authorization     = 'Basic ' . base64_encode('riot:' . $data[3]);

        $this->url_prefix = $this->connection_method . '://' . $this->host . ':' . $this->port;
        $this->headers    = array('Accept' => 'application/json', 'Authorization' => $this->authorization);
        $this->options    = array('verify' => false);

        echo 'Host             : ' . $this->host              . PHP_EOL;
        echo 'Port             : ' . $this->port              . PHP_EOL;
        echo 'Connecton method : ' . $this->connection_method . PHP_EOL;
        echo 'Authorization    : ' . $this->authorization     . PHP_EOL;
    }

    function get_gameflow()
    {
        # GET /lol-gameflow/v1/gameflow-phase HTTP/1.1
        $response = Requests::get($this->url_prefix . '/lol-gameflow/v1/gameflow-phase', $this->headers, $this->options);
        return $response->body;
    }

    function accept_matchmaking()
    {
        # POST /lol-matchmaking/v1/ready-check/accept HTTP/1.1
        $response = Requests::post($this->url_prefix . '/lol-matchmaking/v1/ready-check/accept', $this->headers, array(), $this->options);
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
$lockfile = getenv('LOCKFILE') . '\\lockfile';
if (is_file($lockfile) == false) {
    echo 'The path is not exist or LeagueClient.exe is not in process !' . PHP_EOL;
    system('pause');
    exit();
}

# Main loop
$league_client = new LeagueClient($lockfile);
$league_client->get_gameflow();
$league_client->accept_matchmaking();

?>
