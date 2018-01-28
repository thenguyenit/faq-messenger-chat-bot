<?php

namespace App\Model\Message;

class KindOfIssue implements MessageInterface {

    public function getMessage()
    {
        return  [
            "attachment" => [
                "type" => "template",
                "payload" => [
                    "template_type" => "button",
                    "text" => "I am so sorry for your bad experience with our product. Please let me help you. What kind of issue did you get?",
                    "buttons" => [
                        [
                            "type" => "postback",
                            "title" => "Pairing/Syncing",
                            "payload" => "I got a sync issue"
                        ],
                        [
                            "type" => "web_url",
                            "title" => "Battery",
                            "url" => "https://misfit.com/catalogsearch/result/support/?faq-search=battery"
                        ],
                        [
                            "type" => "web_url",
                            "title" => "Others",
                            "url" => "https://misfit.com/support/"
                        ],
                    ]
                ]
            ]
        ];
    }

//    public function getGeneralUrl()
//    {
//        switch () {
//            case :
//                break;
//            default:
//                break;
//        }
//    }
}