<?php

namespace App\Model\Message;

class KindOfTechnicalIssue implements MessageInterface {

    public function getMessage()
    {
        return  [
            "attachment" => [
                "type" => "template",
                "payload" => [
                    "template_type" => "button",
                    "text" => "Thank you. To help me more easily investigate your issue. Could you choose a specific issue below?",
                    "buttons" => [
                        [
                            "type" => "postback",
                            "title" => "Sync issue",
                            "payload" => "I got a sync issue"
                        ],
                        [
                            "type" => "postback",
                            "title" => "Power consumption issue",
                            "payload" => "I got a power consumption issue"
                        ],
                        [
                            "type" => "postback",
                            "title" => "Internet issue",
                            "payload" => "I got a internet issue issue"
                        ],
                    ]
                ]
            ]
        ];
    }

}