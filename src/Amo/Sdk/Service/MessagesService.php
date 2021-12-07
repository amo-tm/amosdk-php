<?php

namespace Amo\Sdk\Service;

use Amo\Sdk\Models\Messages\ConversationIdentityInterface;
use Amo\Sdk\Models\Messages\Message;

class MessagesService extends AbstractService
{
    public function send(ConversationIdentityInterface $conversation, Message $message): ?Message {
        $requestUrl = '/' . $conversation->getType() . '/' . $conversation->getId() . '/sendMessage';
        $response = $this->apiClient->post($requestUrl, [
            'body' => $message
        ]);
        return Message::fromStream($response->getBody());
    }
}