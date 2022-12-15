<?php
declare(strict_types=1);

namespace Elephox\Collection;

use PHPUnit\Framework\TestCase;
use stdClass;

/**
 * @covers \Elephox\Collection\ObjectMap
 * @covers \Elephox\Collection\OffsetNotFoundException
 * @covers \Elephox\Collection\InvalidOffsetException
 * @covers \Elephox\Collection\ArrayList
 * @covers \Elephox\Collection\Iterator\FlipIterator
 * @covers \Elephox\Collection\Enumerable
 *
 * @internal
 */
class ObjectMapTest extends TestCase
{
	public function testConstructor(): void
	{
		$inst = new stdClass();
		$map = new ObjectMap(
			[
				$inst,
			],
			[
				123,
			],
		);

		static::assertSame(123, $map->get($inst));
	}

	public function testConstructorUnevenArrays(): void
	{
		$inst = new stdClass();
		$inst2 = new stdClass();

		$this->expectException(OffsetNotFoundException::class);

		new ObjectMap(
			[
				$inst,
				$inst2,
			],
			[
				123,
			],
		);
	}

	public function testGetInvalidOffset(): void
	{
		$map = new ObjectMap();

		$this->expectException(OffsetNotFoundException::class);

		$map->get(new stdClass());
	}

	public function testHas(): void
	{
		$inst = new stdClass();
		$map = new ObjectMap([$inst], [123]);

		static::assertTrue($map->has($inst));
	}

	public function testIterator(): void
	{
		$inst = new stdClass();
		$map = new ObjectMap([$inst], [123]);

		foreach ($map as $key => $value) {
			static::assertSame($inst, $key);
			static::assertSame(123, $value);
		}
	}

	public function testPut(): void
	{
		$inst = new stdClass();
		$map = new ObjectMap([$inst], [123]);

		$added = $map->put($inst, 456);

		static::assertFalse($added);
		static::assertSame(456, $map->get($inst));

		$anotherAdded = $map->put(new stdClass(), 789);

		static::assertTrue($anotherAdded);
	}

	public function testRemove(): void
	{
		$inst = new stdClass();
		$map = new ObjectMap([$inst], [123]);

		$removed = $map->remove($inst);

		static::assertTrue($removed);
		static::assertFalse($map->has($inst));

		$removedAgain = $map->remove($inst);

		static::assertFalse($removedAgain);
	}

	public function testClear(): void
	{
		$inst = new stdClass();
		$map = new ObjectMap([$inst], [123]);

		static::assertTrue($map->has($inst));

		$map->clear();

		static::assertFalse($map->has($inst));
	}
}
