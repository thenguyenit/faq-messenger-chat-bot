<?php

namespace App\Model\Message;

class KindOfIssue {

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
                            "title" => "Technical",
                            "payload" => "My issue about technical"
                        ],
                        [
                            "type" => "web_url",
                            "title" => "Shipment",
                            "url" => "https://misfit.com/contactform/"
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