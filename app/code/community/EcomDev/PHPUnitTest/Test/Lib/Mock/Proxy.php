<?php
/**
 * PHP Unit test suite for Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @category   EcomDev
 * @package    EcomDev_PHPUnit
 * @copyright  Copyright (c) 2013 EcomDev BV (http://www.ecomdev.org)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @author     Ivan Chepurnyi <ivan.chepurnyi@ecomdev.org>
 */

class EcomDev_PHPUnitTest_Test_Lib_Mock_Proxy extends \PHPUnit\Framework\TestCase
{
    /**
     * @var EcomDev_PHPUnit_Mock_Proxy
     */
    protected $mockProxy;

    /**
     *
     */
    protected function setUp(): void
    {
        $this->mockProxy = new EcomDev_PHPUnit_Mock_Proxy($this, 'EcomDev_PHPUnit_AbstractConstraint');
        $this->mockProxy->disableOriginalConstructor();
    }

    /**
     * Test addition of the method into mock proxy
     *
     *
     */
    public function testAddMethod()
    {
        $this->mockProxy->addMethod('methodName');
        $this->assertTrue(method_exists($this->mockProxy->getMock(), 'methodName'));
        $this->mockProxy->addMethod('methodName2');
        $this->assertTrue(method_exists($this->mockProxy->getMock(), 'methodName2'));
    }

    public function testRemoveMethod()
    {
        EcomDev_Utils_Reflection::setRestrictedPropertyValue($this->mockProxy, 'methods', array(
            'methodName', 'methodName2', 'methodName3',
        ));

        $this->mockProxy->removeMethod('methodName2');
        $this->assertTrue(method_exists($this->mockProxy->getMock(), 'methodName'));
        $this->assertTrue(method_exists($this->mockProxy->getMock(), 'methodName3'));
        $this->mockProxy->removeMethod('methodName');
        $this->assertTrue(method_exists($this->mockProxy->getMock(), 'methodName3'));
    }

    public function testGetMockInstance()
    {
        $mockInstance = $this->mockProxy->getMockInstance();

        $this->assertInstanceOf(
            '\PHPUnit\Framework\MockObject\MockObject',
            $mockInstance
        );

        $this->assertInstanceOf(
            'EcomDev_PHPUnit_AbstractConstraint',
            $mockInstance
        );

        $this->assertSame($mockInstance, $this->mockProxy->getMockInstance());
    }

    public function testGetMockClass()
    {
        $this->assertSame(
            get_class($this->mockProxy->getMockInstance()),
            $this->mockProxy->getMockClass()
        );
    }

    public function testExpects()
    {
        $this->assertInstanceOf(
            \PHPUnit\Framework\MockObject\Builder\InvocationMocker::class,
            $this->mockProxy->expects($this->any())->method($this->anything())
        );
        $this->assertInstanceOf(EcomDev_PHPUnit_AbstractConstraint::class, $this->mockProxy->getMockInstance());
    }

    public function testGetInvocationMocker()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('getMockInstance');
        $this->mockProxy->__phpunit_getInvocationMocker();
    }

    public function testVerify()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('getMockInstance');
        $this->mockProxy->__phpunit_verify();
    }


    public function testCall()
    {
        // Just checks that call is forwarded to mocked class functionality
        $this->assertEquals(false, $this->mockProxy->compareValues('value1', 'value2'));
        $this->assertEquals(true, $this->mockProxy->compareValues('value1', 'value1'));
    }

}
