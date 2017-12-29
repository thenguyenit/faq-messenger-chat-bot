<?php

namespace App\Model\Message;

class IsThisAnIssue {

    public function getMessage()
    {
        return  [
            "attachment" => [
                "type" => "template",
                "payload" => [
                    "template_type" => "button",
                    "text" => "Did you get a bad experience with our product?",
                    "buttons" => [
                        [
                            "type" => "postback",
                            "title" => "Yes",
                            "payload" => "I got a bad experience"
                        ],
                        [
                            "type" => "postback",
                            "title" => "No",
                            "payload" => "I did not get a bad experience"
                        ],
                    ]
                ]
            ]
        ];
    }

}