<?php

declare(strict_types=1);

namespace MitinSany\PushCommon\Services;

use Enqueue\AmqpLib\AmqpConnectionFactory;
use Enqueue\AmqpLib\AmqpContext;
use Interop\Amqp\AmqpQueue;
use Interop\Queue\Consumer;
use Interop\Queue\Exception;
use Interop\Queue\Exception\InvalidDestinationException;
use Interop\Queue\Exception\InvalidMessageException;
use WildWolf\Utils\Singleton;

class AMQPService
{
    use Singleton;

    private array $consumers = [];
    private array $declaredQueues = [];

    private AmqpConnectionFactory $factory;
    private AmqpContext $context;

    /**
     * @param string $queueName
     * @return AmqpQueue
     */
    public function declareQueueByConfigName(string $queueName): AmqpQueue
    {
        if (empty($this->declaredQueues[$queueName])) {
            $config = config("amqp.queues.$queueName");

            /** @var AmqpQueue $queue */
            $queue = $this->getContext()->createQueue($queueName);

            // apply parameters from config
            if (!empty($config['flags']['passive'])) {
                $queue->addFlag(AmqpQueue::FLAG_PASSIVE);
            }
            if (!empty($config['flags']['durable'])) {
                $queue->addFlag(AmqpQueue::FLAG_DURABLE);
            }
            if (!empty($config['flags']['auto_delete'])) {
                $queue->addFlag(AmqpQueue::FLAG_AUTODELETE);
            }
            if (!empty($config['flags']['no_wait'])) {
                $queue->addFlag(AmqpQueue::FLAG_NOWAIT);
            }
            if (!empty($config['flags']['if_unsed'])) {
                $queue->addFlag(AmqpQueue::FLAG_IFUNUSED);
            }
            if (!empty($config['flags']['exclusive'])) {
                $queue->addFlag(AmqpQueue::FLAG_EXCLUSIVE);
            }
            if (!empty($config['flags']['if_empty'])) {
                $queue->addFlag(AmqpQueue::FLAG_IFEMPTY);
            }
            $this->getContext()->declareQueue($queue);
            $this->declaredQueues[$queueName] = $queue;
        }
        return $this->declaredQueues[$queueName];
    }

    /**
     * @param string $queueName
     * @param string $data
     * @return void
     * @throws Exception
     * @throws \Interop\Queue\Exception\Exception
     * @throws InvalidDestinationException
     * @throws InvalidMessageException
     */
    public function sendToQueue(string $queueName, string $data)
    {
        $queue = $this->declareQueueByConfigName($queueName);
        $message = $this->getContext()->createMessage($data);
        $message->setContentType('application/json');
        $this->getContext()->createProducer()->send($queue, $message);
    }

    /**
     * @return AmqpConnectionFactory
     */
    public function getFactory(): AmqpConnectionFactory
    {
        if (empty($this->factory)) {
            $this->factory = new AmqpConnectionFactory([
                'host' => config('amqp.host'),
                'port' => config('amqp.port'),
                'vhost' => config('amqp.vhost', '/'),
                'user' => config('amqp.user'),
                'pass' => config('amqp.password'),
                'persisted' => config('amqp.persisted'),
            ]);
        }
        return $this->factory;
    }

    /**
     * @return AmqpContext
     */
    public function getContext(): AmqpContext
    {
        if (empty($this->context)) {
            $this->context = $this->getFactory()->createContext();
        }
        return $this->context;
    }

    /**
     * @param AmqpContext $context
     * @param string $queueName
     * @return Consumer
     */
    public function getConsumer(AmqpContext $context, string $queueName): Consumer
    {
        $queue = $this->declareQueueByConfigName($queueName);
        if (empty($this->consumers[$queueName])) {
            $this->consumers[$queueName] = $context->createConsumer($queue);
        }
        return $this->consumers[$queueName];
    }

    /**
     * @param string $queueName
     * @param callable $callback
     * @return void
     */
    public function consume(string $queueName, callable $callback): void
    {
        $consumer = $this->getConsumer($this->getContext(), $queueName);

        while ($message = $consumer->receive()) {
            $callback($message);
            $consumer->acknowledge($message);
        }
    }
}
