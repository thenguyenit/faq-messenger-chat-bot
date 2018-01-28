<?php

namespace App\Model\Facebook;

use App\Helper\Logger;

class GraphAPI {

    protected $client;
    protected $logger;

    public function __construct()
    {
        $this->logger = new Logger();

        $this->client = new \Facebook\Facebook([
            'app_id' => getenv('FB_APP_ID'),
            'app_secret' => getenv('FB_APP_SECRET'),
            'default_graph_version' => getenv('FB_GRAPH_VERSION'),
            'default_access_token' => getenv('FB_ACCESS_TOKEN'),
        ]);
    }


    public function getInfo($userId, array $data = [])
    {
        if ($userId) {
            try {
                // Get the \Facebook\GraphNodes\GraphUser object for the current user.
                // If you provided a 'default_access_token', the '{access-token}' is optional.
                $response = $this->client->get('/' . $userId . '?fields=first_name,last_name');
                $me = $response->getGraphUser();
                return $me;

            } catch(\Facebook\Exceptions\FacebookResponseException $e) {
                // When Graph returns an error
                $this->logger->debug('Graph returned an error: ' . $e->getMessage());

            } catch(\Facebook\Exceptions\FacebookSDKException $e) {
                $this->logger->debug('Facebook SDK returned an error: ' . $e->getMessage());
            }
        } else {
            $this->logger->debug('The data is not valid (' . json_encode($data) . ')');
        }

        return;
    }

}