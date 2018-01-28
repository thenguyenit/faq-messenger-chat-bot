<?php

namespace App\Model\Message;

use App\Model\Facebook\GraphAPI;
use App\Model\Zendesk\Zendesk;
use App\Helper\Logger;

class CreateZendeskTicket implements MessageInterface {

    protected $zendeskClient;
    protected $logger;
    protected $input;
    protected $facebookGraphAPI;

    public function __construct(array $input = [])
    {
        $this->zendeskClient = new Zendesk();
        $this->logger = new Logger();
        $this->input = $input;
        $this->facebookGraphAPI = new GraphAPI();
    }

    public function getMessage()
    {
        $me = $this->facebookGraphAPI->getInfo($this->input['senderid']);

        $ticketData = [
            'subject' => 'Test create zendesk ticket',
            'body' => 'Time: ' . date('Y-m-d H:i:s'),
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
                                "title" => "I am sorry about that.",
                                "subtitle" => "I created a ticket for our technical team. They will handle it and reply to you in 24 hours.",
                                "item_url" => "https://misfit.com/contactform/",
                                "image_url" => "https://c1.sfdcstatic.com/content/dam/blogs/us/Mar2016/20interactive.png",
                                "buttons" => [
//                                    [
//                                        "type" => "web_url",
//                                        "url" => $newTicket->ticket->url,
//                                        "title" => "Ticket ID: #" . $newTicket->ticket->id
//                                    ],
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