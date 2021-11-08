<?php
declare(strict_types=1);

namespace Philly\Collection\Contract;

use Countable;
use IteratorAggregate;

/**
 * @template T
 *
 * @extends \Philly\Collection\Contract\GenericCollection<T>
 * @extends \IteratorAggregate<int, T>
 */
interface ReadonlyList extends GenericCollection, Countable, IteratorAggregate
{
	/**
	 * @return T
	 */
	public function get(int $index): mixed;

	/**
	 * @param callable(T): bool $filter
	 * @return GenericList<T>
	 */
	public function where(callable $filter): GenericList;

	/**
	 * @template TOut
	 *
	 * @param callable(T): TOut $callback
	 * @return GenericList<TOut>
	 */
	public function map(callable $callback): GenericList;

	public function isEmpty(): bool;
}
