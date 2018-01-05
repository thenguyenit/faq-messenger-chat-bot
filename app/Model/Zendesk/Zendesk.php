<?php

namespace App\Model\Zendesk;

use Zendesk\API\HttpClient as ZendeskAPI;

class Zendesk {

    protected $client;
    protected $logger;

    public function __construct()
    {
        $this->logger = new Logger();

        $subdomain = getenv('ZENDESK_SUBDOMAIN');
        $username  = getenv('ZENDESK_USERNAME');
        $token     = getenv('ZENDESK_TOKEN');

        $this->client = new ZendeskAPI($subdomain);
        $this->client->setAuth('basic', ['username' => $username, 'token' => $token]);
    }

    /**
     * @param array $data
     * @return null|\stdClass
     */
    public function create(array $data)
    {
        if (isset($data['subject']) && isset($data['body'])) {
            $newTicket = $this->client->tickets()->create([
                'subject' => $data['subject'],
                'comment' => [
                    'body' => $data['body']
                ],
                'priority' => isset($data['priority']) ? $data['priority'] : 'normal'
            ]);

            return $newTicket;
        } else {
            $this->logger->debug('The ticket data is not valid (' . json_encode($data) . ')');
            return;
        }
    }

}