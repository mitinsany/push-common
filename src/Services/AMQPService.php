<?php

declare(strict_types=1);

namespace MitinSany\PushCommon\Services;

use Enqueue\AmqpLib\AmqpConnectionFactory;
use Enqueue\AmqpLib\AmqpContext;
use Interop\Amqp\AmqpQueue;
use WildWolf\Utils\Singleton;

class AMQPService
{
    use Singleton;

    protected array $declaredQueues = [];

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
            if(!empty($config['consumer_tags'])) {
                foreach((array)$config['consumer_tags'] as $consumerTag) {
                    $queue->setConsumerTag($consumerTag);
                }
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
                'vhost' => config('amqp.vhost', '/'),
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
}
