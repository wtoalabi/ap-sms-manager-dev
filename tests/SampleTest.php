<?php
	
	namespace Tests;
	
	use App\SampleClass;
	use WP_Mock\Tools\TestCase;
	use WP_Mock;
	use ReflectionMethod;
	
	class SampleTest extends TestCase
	{
		public function setUp(): void
		{
			WP_Mock::setUp();
			
		}
		
		/**
		 *
		 */
		public function tearDown():void
		{
			WP_Mock::tearDown();
		}
		
		/**
		 * @covers App\SampleClass
		 */
		public function testSample()
		{
			$sampleClass = new SampleClass();
			$this->assertInstanceOf(SampleClass::class, $sampleClass);
			$this->assertEquals(1, 1);
			$this->assertEquals(10, 10);
			$this->assertEquals("Yes", "Yes");
		}
	}
