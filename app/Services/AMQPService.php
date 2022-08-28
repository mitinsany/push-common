<?php

namespace MitinSany\PushCommon\App\Services;

use MitinSany\PushCommon\App\Enums\AMQPService\QueueNamesEnum;
use Enqueue\AmqpLib\AmqpConnectionFactory;
use Enqueue\AmqpLib\AmqpContext;
use Interop\Amqp\AmqpQueue;

class AMQPService
{
    protected array $declaredQueues = [];

    private AmqpConnectionFactory $factory;
    private AmqpContext $context;

    /**
     * @return AbstractConnection
     *
    protected function getConnection(): AbstractConnection
    {
        if (empty($this->connection)) {
            $this->connection = new AMQPStreamConnection(
                config('amqp.host'),
                config('amqp.port'),
                config('amqp.user'),
                config('amqp.password')
            );
        }
        return $this->connection;
    }

    public function getChannel(): AbstractChannel
    {
        if (empty($this->channel)) {
            $this->channel = $this->getConnection()->channel();
        }
        return $this->channel;
    }*/

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

    public function send(string $queueName, string $data)
    {
        $queue = $this->declareQueueByConfigName($queueName);
        $message = $this->getContext()->createMessage($data);
        $this->getContext()->createProducer()->send($queue, $message);
    }

    public function getFactory(): AmqpConnectionFactory
    {
        if (empty($this->factory)) {
            $this->factory = new AmqpConnectionFactory([
                'host' => config('amqp.host'),
                'port' => config('amqp.port'),
                'vhost' => '/',
                'user' => config('amqp.user'),
                'pass' => config('amqp.password'),
                'persisted' => false,
            ]);
        }
        return $this->factory;
    }

    public function getContext(): AmqpContext
    {
        if (empty($this->context)) {
            $this->context = $this->getFactory()->createContext();
        }
        return $this->context;
    }

    public function consumeReceive(): void
    {
        $queue = $this->declareQueueByConfigName(QueueNamesEnum::PUSH_MESSAGES);
        $consumer = $this->getContext()->createConsumer($queue);
        while ($message = $consumer->receive()) {
            echo $message->getBody() . PHP_EOL;
            // process a message
            $consumer->acknowledge($message);
        }
    }
}
