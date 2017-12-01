<?php

namespace App\Model\Message;

class Welcome 
{
    public function getMessage()
    {
        return  [
            "attachment" => [
                "type" => "template",
                "payload" => [
                    "template_type" => "generic",
                    "elements" => [
                        [
                            "title" => "Migrate your symfony application",
                            "item_url" => "https://www.cloudways.com/blog/migrate-symfony-from-cpanel-to-cloud-hosting/",
                            "image_url" => "https://www.cloudways.com/blog/wp-content/uploads/Migrating-Your-Symfony-Website-To-Cloudways-Banner.jpg",
                            "subtitle" => "Migrate your symfony application from Cpanel to Cloud.",
                            "buttons" => [
                                [
                                    "type" => "web_url",
                                    "url" => "www.cloudways.com",
                                    "title" => "View Website"
                                ],
                                [
                                    "type" => "postback",
                                    "title" => "Start Chatting",
                                    "payload" => "get started"
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];
    }
}