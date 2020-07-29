<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Base;

/**
 * @template TKey
 * @psalm-template TKey of array-key
 * @template T
 */
interface Untilable
{
    /**
     * @param callable ...$callbacks
     * @psalm-param callable(T, TKey):(bool) ...$callbacks
     *
     * @return \loophp\collection\Base<TKey, T>|\loophp\collection\Contract\Collection<TKey, T>
     */
    public function until(callable ...$callbacks): Base;
}
