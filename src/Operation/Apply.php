<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\Operation;

/**
 * @template TKey
 * @psalm-template TKey of array-key
 * @template T
 */
final class Apply extends AbstractOperation implements Operation
{
    /**
     * @param callable ...$callbacks
     * @psalm-param callable(T, TKey):(bool) ...$callbacks
     */
    public function __construct(callable ...$callbacks)
    {
        $this->storage['callbacks'] = $callbacks;
    }

    /**
     * @psalm-template U
     *
     * @psalm-return \Closure(\Iterator<TKey, T>, list<callable(T, TKey):(U)>):(\Generator<TKey, T>)
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-template U
             *
             * @psalm-param \Iterator<TKey, T> $iterator
             * @psalm-param list<callable(T, TKey):(U)> $callbacks
             */
            static function (Iterator $iterator, array $callbacks): Generator {
                foreach ($iterator as $key => $value) {
                    foreach ($callbacks as $callback) {
                        if (true === $callback($value, $key)) {
                            continue;
                        }

                        break;
                    }

                    yield $key => $value;
                }
            };
    }
}
