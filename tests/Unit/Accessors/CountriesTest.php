<?php

namespace Tests\Unit\Accessors;

use Aboleon\MetaFramework\Models\Meta;
use PHPUnit\Framework\TestCase;

class CountriesTest extends TestCase
{

    private function countries(): array
    {
        return
            [
                'AF' => 'Afghanistan'
            ];
    }

    private function getCountryNameByCode(?string $code = null): string
    {
        return $this->countries()[$code] ?? 'NC';
    }

    /** @test */
    public function feching_country_name_by_variable_returns_string()
    {

        $this->assertTrue($this->getCountryNameByCode('AF') === 'Afghanistan');

        // NC is returned on an uknown string
        $this->assertTrue($this->getCountryNameByCode('DE') === 'NC');

        // NC is returned on null
        $this->assertTrue($this->getCountryNameByCode() === 'NC');

    }
}
