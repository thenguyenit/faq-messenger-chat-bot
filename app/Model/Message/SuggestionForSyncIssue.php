<?php

namespace App\Model\Message;

class SuggestionForSyncIssue implements MessageInterface {

    public function getMessage()
    {
        return  [
            "attachment" => [
                "type" => "template",
                "payload" => [
                    "template_type" => "list",
                    "top_element_style" => "COMPACT",
                    "elements" => [
                        [
                            "title" => "Device is out of battery",
                            "subtitle" => "Solution: replace your battery",
                            "image_url" => "https://peterssendreceiveapp.ngrok.io/img/collection.png",

                        ],
                    ]
                ]
            ]
        ];
    }

}