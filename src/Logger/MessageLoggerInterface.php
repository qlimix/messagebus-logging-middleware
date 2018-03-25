<?php declare(strict_types=1);

namespace Qlimix\MessageBus\Logger;

use Qlimix\MessageBus\Message\MessageInterface;

interface MessageLoggerInterface
{
    /**
     * @param MessageInterface $message
     */
    public function start(MessageInterface $message): void;

    /**
     * @param MessageInterface $message
     */
    public function success(MessageInterface $message): void;

    /**
     * @param MessageInterface $message
     * @param \Throwable $exception
     */
    public function failed(MessageInterface $message, \Throwable $exception): void;

    /**
     * @param MessageInterface $message
     * @param \Throwable $exception
     */
    public function critical(MessageInterface $message, \Throwable $exception): void;
}
