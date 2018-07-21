<?php declare(strict_types=1);

namespace Qlimix\MessageBus\Logger;

use Qlimix\Serializable\SerializableInterface;

interface MessageLoggerInterface
{
    /**
     * @param SerializableInterface $message
     */
    public function start(SerializableInterface $message): void;

    /**
     * @param SerializableInterface $message
     */
    public function success(SerializableInterface $message): void;

    /**
     * @param SerializableInterface $message
     * @param \Throwable $exception
     */
    public function failed(SerializableInterface $message, \Throwable $exception): void;

    /**
     * @param SerializableInterface $message
     * @param \Throwable $exception
     */
    public function critical(SerializableInterface $message, \Throwable $exception): void;
}
