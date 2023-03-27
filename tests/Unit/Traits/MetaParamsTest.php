<?php

namespace Tests\Unit\Traits;

use MetaFramework\Models\Meta;
use PHPUnit\Framework\TestCase;

class MetaParamsTest extends TestCase
{

    /** @test */
    public function form_usage_is_disabled_by_default_and_can_be_set_by_method_call()
    {
        // Arrange
        $testable = new Meta();

        $this->assertFalse($testable->isUsingForms());

        // Act
        $testable->hasForms();

        // Assert
        $this->assertTrue($testable->isUsingForms());
    }

    /**
     * @test
     * @covers MetaParams::isUsingBlocs
     */
    public function bloc_usage_is_disabled_by_default_and_can_be_set_by_method_call()
    {
        // Arrange
        $testable = new Meta();

        $this->assertFalse($testable->isUsingBlocs());

        // Act
        $testable->hasBlocs();

        // Assert
        $this->assertTrue($testable->isUsingBlocs());
    }

    /**
     * @test
     * @covers MetaParams::reliesOnMeta
     * @covers MetaParams::isReliyingOnMeta
     */
    public function submodel_is_using_meta_table()
    {
        // Arrange
        $testable = new Meta();

        $this->assertFalse($testable->isUsingBlocs());

        // Act
        $testable->hasBlocs();

        // Assert
        $this->assertTrue($testable->isUsingBlocs());
    }
}
