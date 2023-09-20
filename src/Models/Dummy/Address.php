<?php

namespace MetaFramework\Models\Dummy;

use MetaFramework\Interfaces\GooglePlacesInterface;

class Address implements GooglePlacesInterface
{

    public ?string $country_code = null;

}
