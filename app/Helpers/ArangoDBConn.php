<?php

namespace App\Helpers;

use App\Helpers\ArangoDBConnInterface;
use ArangoDBClient;
use ArangoDBClient\ClientException as ArangoClientException;
use ArangoDBClient\ConnectException as ArangoConnectException;
use ArangoDBClient\Connection as ArangoConnection;
use ArangoDBClient\ConnectionOptions as ArangoConnectionOptions;
use ArangoDBClient\Document as ArangoDocument;
use ArangoDBClient\ServerException as ArangoServerException;
use ArangoDBClient\UpdatePolicy as ArangoUpdatePolicy;
use Config;

class ArangoDBConn implements ArangoDBConnInterface
{
    public function conn()
    {
        $connectionOptions = [
            // database name
            ArangoConnectionOptions::OPTION_DATABASE => env('DB_DATABASE'),
            // server endpoint to connect to
            ArangoConnectionOptions::OPTION_ENDPOINT => env('DB_ENDPOINT'),
            // authorization type to use (currently supported: 'Basic')
            ArangoConnectionOptions::OPTION_AUTH_TYPE => env('OPTION_AUTH_TYPE'),
            // user for basic authorization
            ArangoConnectionOptions::OPTION_AUTH_USER => env('DB_USERNAME'),
            // password for basic authorization
            ArangoConnectionOptions::OPTION_AUTH_PASSWD => env('DB_PASSWORD'),
            // connection persistence on server. can use either 'Close' (one-time connections) or 'Keep-Alive' (re-used connections)
            ArangoConnectionOptions::OPTION_CONNECTION => env('OPTION_CONNECTION'),
            // connect timeout in seconds
            ArangoConnectionOptions::OPTION_TIMEOUT => env('OPTION_TIMEOUT'),
            // whether or not to reconnect when a keep-alive connection has timed out on server
            ArangoConnectionOptions::OPTION_RECONNECT => env('OPTION_RECONNECT'),
            // optionally create new collections when inserting documents
            ArangoConnectionOptions::OPTION_CREATE => env('OPTION_CREATE'),
            // optionally create new collections when inserting documents
            ArangoConnectionOptions::OPTION_UPDATE_POLICY => ArangoUpdatePolicy::LAST,
        ];
        return $connection = new ArangoConnection($connectionOptions);
    }
}
