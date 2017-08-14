<?php

namespace Shapecode\Swiftmailer\Plugins;

/**
 * Class ImpersonatePlugin
 *
 * @package Shapecode\Swiftmailer\Plugins
 * @author  Nikita Loges
 */
class ImpersonatePlugin implements \Swift_Events_SendListener
{

    /** @var string */
    protected $address;

    /** @var string */
    protected $name;

    /**
     * @param      $address
     * @param null $name
     */
    public function __construct($address, $name = null)
    {
        $this->address = $address;
        $this->name = $name;
    }

    /**
     * @param \Swift_Events_SendEvent $event
     */
    public function beforeSendPerformed(\Swift_Events_SendEvent $event)
    {
        $message = $event->getMessage();
        $headers = $message->getHeaders();

        $headers->addMailboxHeader('X-Swift-From', $message->getFrom());
        $message->setFrom($this->address, $this->name);
    }

    /**
     * @param \Swift_Events_SendEvent $event
     */
    public function sendPerformed(\Swift_Events_SendEvent $event)
    {
        $message = $event->getMessage();
        $headers = $message->getHeaders();

        $originalFrom = $headers->get('X-Swift-From')->getFieldBodyModel();
        $message->setFrom($originalFrom);
    }
}
