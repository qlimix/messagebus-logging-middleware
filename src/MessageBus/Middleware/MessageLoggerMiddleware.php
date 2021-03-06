<?php declare(strict_types=1);

namespace Qlimix\MessageBus\MessageBus\Middleware;

use Qlimix\Logging\Logger\Message\MessageLoggerInterface;
use Qlimix\MessageBus\MessageBus\Middleware\Exception\MiddlewareException;
use Throwable;

final class MessageLoggerMiddleware implements MiddlewareInterface
{
    private MessageLoggerInterface $logger;

    public function __construct(MessageLoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @inheritDoc
     */
    public function handle($message, MiddlewareHandlerInterface $handler): void
    {
        $this->logger->start($message);

        try {
            $handler->next($message, $handler);
        } catch (MiddlewareException $exception) {
            throw $exception;
        } catch (Throwable $exception) {
            $this->logger->failed($message, $exception);

            throw $exception;
        }

        $this->logger->success($message);
    }
}
