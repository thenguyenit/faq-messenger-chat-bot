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
                    "top_element_style" => "compact",
                    "elements" => [
                        [
                            "title" => "Your device battery might be low, Could you try replace your battery, please?",
                            "image_url" => IMG_STATIC_URL . '/battery.png',
                            "default_action" => [
                                "type" => "web_url",
                                    "url" => "https://misfit.com/catalogsearch/result/support/?faq-search=battery",
                                    "messenger_extensions" => false,
                                    "webview_height_ratio" => "tall"
                                ]
                        ],
                        [
                            "title" => "Your device might be out of Bluetooth range, keep it still within Bluetooth range",
                            "subtitle" => "Bluetooth range is 10 meters (30 feet) if there are no doors",
                            "image_url" => IMG_STATIC_URL . '/bluetooth.png',
                            "default_action" => [
                                "type" => "web_url",
                                "url" => "https://misfit.com/catalogsearch/result/support/?faq-search=bluetooth",
                                "messenger_extensions" => false,
                                "webview_height_ratio" => "tall"
                            ]
                        ],
                        [
                            "title" => "Please make sure you have a good internet connection",
                            "image_url" => IMG_STATIC_URL . '/wi-fi.png',
                            "default_action" => [
                                "type" => "web_url",
                                "url" => "https://misfit.com/catalogsearch/result/support/?faq-search=internet",
                                "messenger_extensions" => false,
                                "webview_height_ratio" => "tall"
                            ]
                        ],
                    ]
                ]
            ],
        ];
    }

}