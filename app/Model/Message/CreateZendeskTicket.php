<?php

namespace App\Model\Message;

use App\Model\Zendesk\Zendesk;
use App\Helper\Logger;

class CreateZendeskTicket {

    protected $zendeskClient;
    protected $logger;

    public function __construct()
    {
        $this->zendeskClient = new Zendesk();
        $this->logger = new Logger();
    }

    public function getMessage()
    {
        $ticketData = [
            'subject' => 'Test create zendesk ticket',
            'body' => 'Time: ' . new \DateTime('Y-m-d H:i:s')
        ];

        $this->logger->debug('Ticket Data', $ticketData);

        $newTicket = $this->zendeskClient->create($ticketData);
        if ($newTicket) {
            return  [
                "attachment" => [
                    "type" => "template",
                    "payload" => [
                        "template_type" => "generic",
                        "elements" => [
                            [
    //                            "title" => "Migrate your symfony application",
                                "subtitle" => "I am sorry about that. I created a ticket for our technical team. They will handle it and reply to you in 24 hours.",
                                "item_url" => "https://misfit.com/contactform/",
                                "image_url" => "https://c1.sfdcstatic.com/content/dam/blogs/us/Mar2016/20interactive.png",
                                "buttons" => [
                                    [
                                        "type" => "web_url",
                                        "url" => $ticketData->ticket->url,
                                        "title" => "Ticket ID: #" . $ticketData->ticket->id
                                    ],
                                    [
                                        "type" => "postback",
                                        "title" => "Start chatting with customer service",
                                        "payload" => "I wanna chat with customer service"
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ];
        } else {
            $this->logger->debug('New ticket data is empty');
        }

    }

}