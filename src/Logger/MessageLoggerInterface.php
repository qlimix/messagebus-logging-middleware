<?php declare(strict_types=1);

namespace Qlimix\MessageBus\Logger;

use Qlimix\Serializable\SerializableInterface;

interface MessageLoggerInterface
{
    public function start(SerializableInterface $message): void;

    public function success(SerializableInterface $message): void;

    public function failed(SerializableInterface $message, \Throwable $exception): void;

    public function critical(SerializableInterface $message, \Throwable $exception): void;
}
