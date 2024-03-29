<?php
declare(strict_types=1);

namespace Elephox\Collection\Contract;

/**
 * @template T
 *
 * @extends GenericEnumerable<T>
 */
interface GenericSet extends GenericEnumerable
{
	/**
	 * @param T $value
	 */
	public function add(mixed $value): bool;

	/**
	 * @param iterable<mixed, T> $values
	 */
	public function addAll(iterable $values): bool;

	/**
	 * @param T $value
	 */
	public function remove(mixed $value): bool;

	/**
	 * @param callable(T): bool $predicate
	 */
	public function removeBy(callable $predicate): bool;

	public function removeAll(): bool;
}
