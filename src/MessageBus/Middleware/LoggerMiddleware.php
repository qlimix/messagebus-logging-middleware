<?php declare(strict_types=1);

namespace Qlimix\MessageBus\MessageBus\Middleware;

use Qlimix\MessageBus\Logger\MessageLoggerInterface;
use Qlimix\MessageBus\Message\MessageInterface;
use Qlimix\MessageBus\MessageBus\Middleware\Exception\MiddlewareException;

final class LoggerMiddleware implements MiddlewareInterface
{
    /** @var MessageLoggerInterface */
    private $logger;

    /**
     * @param MessageLoggerInterface $logger
     */
    public function __construct(MessageLoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @inheritDoc
     */
    public function handle(MessageInterface $message, MiddlewareHandlerInterface $handler): void
    {
        $this->logger->start($message);

        try {
            $handler->next($message, $handler);
        } catch (MiddlewareException $exception) {
            throw $exception;
        } catch (\Throwable $exception) {
            $this->logger->failed($message, $exception);
            throw $exception;
        }

        $this->logger->success($message);
    }
}