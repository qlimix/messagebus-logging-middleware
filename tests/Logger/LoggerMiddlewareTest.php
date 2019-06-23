<?php declare(strict_types=1);

namespace Qlimix\Tests\MessageBus\Logger;

use Exception;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Qlimix\Logging\Logger\Message\MessageLoggerInterface;
use Qlimix\MessageBus\MessageBus\Middleware\Exception\MiddlewareException;
use Qlimix\MessageBus\MessageBus\Middleware\LoggerMiddleware;
use Qlimix\MessageBus\MessageBus\Middleware\MiddlewareHandlerInterface;
use Qlimix\Serializable\SerializableInterface;

final class LoggerMiddlewareTest extends TestCase
{
    /** @var MockObject */
    private $logHandler;

    /** @var MockObject */
    private $message;

    /** @var MockObject */
    private $handler;

    /** @var LoggerMiddleware */
    private $loggerMiddleware;

    protected function setUp(): void
    {
        $this->logHandler = $this->createMock(MessageLoggerInterface::class);
        $this->loggerMiddleware = new LoggerMiddleware($this->logHandler);

        $this->message = $this->createMock(SerializableInterface::class);
        $this->handler = $this->createMock(MiddlewareHandlerInterface::class);
    }

    /**
     * @test
     */
    public function shouldLogStartAndSuccessOnHandled(): void
    {
        $this->logHandler->expects($this->once())
            ->method('start');

        $this->logHandler->expects($this->once())
            ->method('success');

        $this->handler->expects($this->once())
            ->method('next');

        $this->loggerMiddleware->handle($this->message, $this->handler);
    }

    /**
     * @test
     */
    public function shouldLogStartAndFailedOnHandleFailure(): void
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

    /**
     * @test
     */
    public function shouldRethrowOnMiddlewareException(): void
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
