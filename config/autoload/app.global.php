<?php
/*
 * This file is part of prooph/proophessor.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Date: 9/6/15 - 5:07 PM
 */
return [
    'prooph' => [
        'middleware' => [
            'query' => [
                'response_strategy' => \Halloween\TrickOrTreat\Response\JsonResponse::class,
                'message_factory' => \Prooph\Common\Messaging\FQCNMessageFactory::class,
            ],
            'command' => [
                'message_factory' => \Prooph\Common\Messaging\FQCNMessageFactory::class,
            ],
            'event' => [
                'message_factory' => \Prooph\Common\Messaging\FQCNMessageFactory::class,
            ],
            'message' => [
//                'response_strategy' => \Prooph\ProophessorDo\Response\JsonResponse::class,
                'message_factory' => \Prooph\Common\Messaging\FQCNMessageFactory::class,
            ],
        ],
        'event_store' => [
            'plugins' => [
                \Prooph\EventStoreBusBridge\EventPublisher::class,
                \Prooph\EventStoreBusBridge\TransactionManager::class,
            ],
            //Repository configuration for EventStoreTodoList
            'available_ingredients' => [
                'repository_class' => Halloween\TrickOrTreat\Infrastructure\Repository\EventStoreAvailableIngredients::class,
                'aggregate_type' => Halloween\TrickOrTreat\Domain\Ingredient\Ingredient::class,
                'aggregate_translator' => \Prooph\EventSourcing\EventStoreIntegration\AggregateTranslator::class,
            ]
        ],
        'service_bus' => [
            'command_bus' => [
                'router' => [
                    'routes' => [
                        \Halloween\TrickOrTreat\Domain\Ingredient\Command\AddIngredient::class => \Halloween\TrickOrTreat\Domain\Ingredient\Handler\AddIngredientHandler::class
                    ],
                ],
            ],
            'event_bus' => [
                'plugins' => [
                    \Prooph\ServiceBus\Plugin\InvokeStrategy\OnEventStrategy::class
                ],
                'router' => [
                    'routes' => [
//                        \Prooph\ProophessorDo\Model\Todo\Event\TodoWasMarkedAsDone::class => [
//                            \Prooph\ProophessorDo\Projection\Todo\TodoProjector::class,
//                            \Prooph\ProophessorDo\Projection\User\UserProjector::class,
//                        ],
                    ],
                ],
            ],
        ],
    ],
];
