<?php declare(strict_types=1);

namespace Qlimix\Tests\MessageBus\Logger;

use Exception;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Qlimix\Logging\Logger\Message\MessageLoggerInterface;
use Qlimix\MessageBus\MessageBus\Middleware\Exception\MiddlewareException;
use Qlimix\MessageBus\MessageBus\Middleware\MessageLoggerMiddleware;
use Qlimix\MessageBus\MessageBus\Middleware\MiddlewareHandlerInterface;
use Qlimix\Serializable\SerializableInterface;

final class LoggerMiddlewareTest extends TestCase
{
    private MockObject $logHandler;

    private MockObject $message;

    private MockObject$handler;

    private MessageLoggerMiddleware $loggerMiddleware;

    protected function setUp(): void
    {
        $this->logHandler = $this->createMock(MessageLoggerInterface::class);
        $this->loggerMiddleware = new MessageLoggerMiddleware($this->logHandler);

        $this->message = $this->createMock(SerializableInterface::class);
        $this->handler = $this->createMock(MiddlewareHandlerInterface::class);
    }

    public function testShouldLogStartAndSuccessOnHandled(): void
    {
        $this->logHandler->expects($this->once())
            ->method('start');

        $this->logHandler->expects($this->once())
            ->method('success');

        $this->handler->expects($this->once())
            ->method('next');

        $this->loggerMiddleware->handle($this->message, $this->handler);
    }

    public function testShouldLogStartAndFailedOnHandleFailure(): void
    {
        $this->logHandler->expects($this->once())
            ->method('start');

        $this->logHandler->expects($this->once())
            ->method('failed');

        $this->handler->expects($this->once())
            ->method('next')
            ->willThrowException(new Exception());

        $this->expectException(Exception::class);

        $this->loggerMiddleware->handle($this->message, $this->handler);
    }

    public function testShouldRethrowOnMiddlewareException(): void
    {
        $this->logHandler->expects($this->once())
            ->method('start');

        $this->handler->expects($this->once())
            ->method('next')
            ->willThrowException(new MiddlewareException());

        $this->expectException(MiddlewareException::class);

        $this->loggerMiddleware->handle($this->message, $this->handler);
    }
}
