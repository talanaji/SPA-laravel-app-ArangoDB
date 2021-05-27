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
            ArangoConnectionOptions::OPTION_DATABASE => Config::get('database.connections.arangodb.database'),
            // server endpoint to connect to
            ArangoConnectionOptions::OPTION_ENDPOINT => Config::get('database.connections.arangodb.endpoint'),
            // authorization type to use (currently supported: 'Basic')
            ArangoConnectionOptions::OPTION_AUTH_TYPE => Config::get('database.connections.arangodb.auth_type'),
            // user for basic authorization
            ArangoConnectionOptions::OPTION_AUTH_USER => Config::get('database.connections.arangodb.auth_user'),
            // password for basic authorization
            ArangoConnectionOptions::OPTION_AUTH_PASSWD => Config::get('database.connections.arangodb.auth_passwd'),
            // connection persistence on server. can use either 'Close' (one-time connections) or 'Keep-Alive' (re-used connections)
            ArangoConnectionOptions::OPTION_CONNECTION => Config::get('database.connections.arangodb.option_connection'),
            // connect timeout in seconds
            ArangoConnectionOptions::OPTION_TIMEOUT => Config::get('database.connections.arangodb.option_timeout'),
            // whether or not to reconnect when a keep-alive connection has timed out on server
            ArangoConnectionOptions::OPTION_RECONNECT => Config::get('database.connections.arangodb.option_reconnect'),
            // optionally create new collections when inserting documents
            ArangoConnectionOptions::OPTION_CREATE => Config::get('database.connections.arangodb.option_create'),
            // optionally create new collections when inserting documents
            ArangoConnectionOptions::OPTION_UPDATE_POLICY => ArangoUpdatePolicy::LAST,
        ];
        return $connection = new ArangoConnection($connectionOptions);
    }
}
