<?php

namespace App\Model\Message;

class SuggestionForSyncIssue implements MessageInterface {

    protected $input;

    /**
     * @var \DialogFlow\Model\Query
     */
    protected $response;

    protected $zendesk;

    const ACTION_REPLACED_BATTERY = 'action_replaced_battery';
    const ACTION_RESET_BLUETOOTH = 'action_reset_bluetooth';
    const ACTION_CONNECTED_INTERNET = 'action_connected_internet';
    const ACTION_SOLVED_SYNC_ALL = 'action_solved_sync_all';
    const MISFIT_SUPPORT = 'misfit_support';


    protected $suggestions = [
        self::ACTION_REPLACED_BATTERY => [
            "title" => "Your device battery might be low, Could you try replace your battery, please?",
            "image_url" => IMG_STATIC_URL . '/icon/battery.png',
            "default_action" => [
                "type" => "web_url",
                "url" => "https://misfit.com/catalogsearch/result/support/?faq-search=battery",
                "messenger_extensions" => false,
                "webview_height_ratio" => "tall"
            ]
        ],
        self::ACTION_RESET_BLUETOOTH => [
            "title" => "Your device might be out of Bluetooth range, keep it still within Bluetooth range",
            "subtitle" => "Bluetooth range is 10 meters (30 feet) if there are no doors",
            "image_url" => IMG_STATIC_URL . '/icon/bluetooth.png',
            "default_action" => [
                "type" => "web_url",
                "url" => "https://misfit.com/catalogsearch/result/support/?faq-search=bluetooth",
                "messenger_extensions" => false,
                "webview_height_ratio" => "tall"
            ]
        ],
        self::ACTION_CONNECTED_INTERNET => [
            "title" => "Please make sure you have a good internet connection",
            "image_url" => IMG_STATIC_URL . '/icon/wi-fi.png',
            "default_action" => [
                "type" => "web_url",
                "url" => "https://misfit.com/catalogsearch/result/support/?faq-search=internet",
                "messenger_extensions" => false,
                "webview_height_ratio" => "tall"
            ]
        ],
        self::MISFIT_SUPPORT => [
            "title" => "Misfit support",
            "image_url" => IMG_STATIC_URL . '/icon/headset.png',
            "default_action" => [
                "type" => "web_url",
                "url" => "https://misfit.com/support/",
                "messenger_extensions" => false,
                "webview_height_ratio" => "tall"
            ]
        ]
    ];

    /**
     * SuggestionForSyncIssue constructor.
     * @param array $input
     * @param \DialogFlow\Model\Query $response
     */
    public function __construct(array $input = [], \DialogFlow\Model\Query $response)
    {
        $this->input = $input;
        $this->response = $response;
        $this->zendesk = new CreateZendeskTicket($input, $response);
    }

    public function getMessage()
    {
        $contexts = $this->getContexts();
        $remainSuggestions = array_diff(array_keys($this->suggestions), $contexts);

        if (is_array($remainSuggestions)) {
            if (count($remainSuggestions) == 1 && $remainSuggestions[0] == self::MISFIT_SUPPORT) {
                //Create Zendesk ticket
                return $this->zendesk->getMessage();

            } else {
                $elements = [];
                foreach ($remainSuggestions as $remainSuggestion) {
                    array_push($elements, $this->suggestions[$remainSuggestion]);
                }

                return  [
                    "attachment" => [
                        "type" => "template",
                        "payload" => [
                            "template_type" => "list",
                            "top_element_style" => "compact",
                            "elements" => $elements
                        ]
                    ],
                ];
            }
        }
    }

    /**
     * Get context keys
     *
     * @return array
     */
    public function getContexts()
    {
        $contexts = $this->response->getResult()->getContexts();
        if (is_array($contexts)) {
            return array_column($contexts, 'name');
        }
    }

}