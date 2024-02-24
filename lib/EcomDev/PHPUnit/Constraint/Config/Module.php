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

/**
 * Module configuration constraint
 */
class EcomDev_PHPUnit_Constraint_Config_Module extends EcomDev_PHPUnit_Constraint_AbstractConfig
{
    const XML_PATH_MODULE_NODE = 'modules/%s';

    const TYPE_IS_ACTIVE = 'is_active';
    const TYPE_CODE_POOL = 'code_pool';
    const TYPE_DEPENDS = 'depends';
    const TYPE_EQUALS_VERSION = 'version';
    const TYPE_LESS_THAN_VERSION = 'version_less_than';
    const TYPE_GREATER_THAN_VERSION = 'version_greater_than';

    protected ?string $_moduleName = null;

    /**
     * Constraint for evaluation of module config node
     *
     * @internal param string $nodePath
     */
    public function __construct(string $moduleName, string $type, mixed $expectedValue)
    {
        $this->_expectedValueValidation += array(
            self::TYPE_CODE_POOL => array(true, 'is_string', 'string'),
            self::TYPE_DEPENDS => array(true, 'is_string', 'string'),
            self::TYPE_EQUALS_VERSION => array(true, 'is_string', 'string'),
            self::TYPE_LESS_THAN_VERSION => array(true, 'is_string', 'string'),
            self::TYPE_GREATER_THAN_VERSION => array(true, 'is_string', 'string'),
        );

        $this->_typesWithDiff[] = self::TYPE_CODE_POOL;
        $this->_typesWithDiff[] = self::TYPE_EQUALS_VERSION;
        $this->_typesWithDiff[] = self::TYPE_LESS_THAN_VERSION;
        $this->_typesWithDiff[] = self::TYPE_GREATER_THAN_VERSION;

        parent::__construct(
            sprintf(self::XML_PATH_MODULE_NODE, $moduleName),
            $type,
            $expectedValue
        );

        $this->_moduleName = $moduleName;
    }

    protected function evaluateIsActive(Varien_Simplexml_Element $other): bool
    {
        return $other->is('active');
    }

    protected function textIsActive(): string
    {
        return 'is active';
    }

    protected function evaluateCodePool(Varien_Simplexml_Element $other): bool
    {
        return $this->compareValues($this->_expectedValue, (string)$other->codePool);
    }

    protected function textCodePool(): string
    {
        return sprintf('is placed in %s code pool', $this->_expectedValue);
    }

    protected function evaluateDepends(Varien_Simplexml_Element $other): bool
    {
        if (! isset($other->depends) || ! $other->depends->hasChildren()) {
            return false;
        }

        return isset($other->depends->{$this->_expectedValue});
    }

    protected function textDepends(): string
    {
        return sprintf('is dependent on %s module', $this->_expectedValue);
    }

    protected function evaluateVersion(Varien_Simplexml_Element $other): bool
    {
        return $this->compareVersion($other, '=');
    }

    protected function textVersion(): string
    {
        return sprintf('version is equal to %s', $this->_actualValue);
    }

    protected function evaluateVersionLessThan(Varien_Simplexml_Element $other): bool
    {
        return $this->compareVersion($other, '<');
    }

    protected function textVersionLessThan(): string
    {
        return sprintf('version is less than %s', $this->_expectedValue);
    }

    protected function evaluateVersionGreaterThan(Varien_Simplexml_Element $other): bool
    {
        return $this->compareVersion($other, '>');
    }

    protected function textVersionGreaterThan(): string
    {
        return sprintf('version is greater than %s', $this->_expectedValue);
    }

    /**
     * Internal comparisment of the module version
     *
     * @param Varien_Simplexml_Element $other
     * @param string $operator
     * @return bool
     */
    protected function compareVersion($other, $operator)
    {
        $this->setActualValue((string)$other->version);
        return version_compare($this->_actualValue, $this->_expectedValue, $operator);
    }

    /**
     * Custom failure description for showing config related errors
     * (non-PHPdoc)
     * @see \PHPUnit\Framework\Constraint\Constraint::customFailureDescription()
     */
    protected function customFailureDescription($other)
    {
        return sprintf(
          '%s module %s.', $this->_expectedValue, $this->toString()
        );
    }
}
