<?php
declare(strict_types=1);

namespace Elephox\Collection;

use Elephox\Collection\Contract\GenericMap;
use SplObjectStorage;
use Traversable;

/**
 * @template TKey of object
 * @template TValue
 *
 * @implements GenericMap<TKey, TValue>
 */
class ObjectMap implements GenericMap
{
	/**
	 * @use IsKeyedEnumerable<TKey, TValue>
	 */
	use IsKeyedEnumerable;

	private SplObjectStorage $map;

	/**
	 * @param array<array-key, TKey> $keys
	 * @param array<array-key, TValue> $values
	 */
	public function __construct(array $keys = [], array $values = [])
	{
		$this->map = new SplObjectStorage();

		foreach ($keys as $index => $key) {
			if (!array_key_exists($index, $values)) {
				throw new OffsetNotFoundException($index);
			}

			$this->put($key, $values[$index]);
		}
	}

	/**
	 * @param object $key
	 * @param TValue $value
	 */
	public function put(mixed $key, mixed $value): bool
	{
		$existed = $this->map->contains($key);

		$this->map->offsetSet($key, $value);

		return !$existed;
	}

	/**
	 * @param object $key
	 *
	 * @return TValue
	 */
	public function get(mixed $key): mixed
	{
		if (!$this->map->offsetExists($key)) {
			throw new OffsetNotFoundException($key);
		}

		/**
		 * @var TValue
		 */
		return $this->map->offsetGet($key);
	}

	/**
	 * @param object $key
	 */
	public function has(mixed $key): bool
	{
		return $this->map->offsetExists($key);
	}

	/**
	 * @return Traversable<TKey, TValue>
	 */
	public function getIterator(): Traversable
	{
		/** @var TKey $key */
		foreach ($this->map as $key) {
			/** @var TValue $value */
			$value = $this->map->offsetGet($key);

			yield $key => $value;
		}
	}

	public function remove(mixed $key): bool
	{
		if (!$this->has($key)) {
			return false;
		}

		$this->map->offsetUnset($key);

		return true;
	}

	public function clear(): void
	{
		$this->map->removeAll($this->map);
	}
}
