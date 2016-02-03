<?php
namespace Strapieno\NightClub\Api\V1\Hydrator;

use Matryoshka\Model\Hydrator\Strategy\HasManyStrategy;
use Matryoshka\Model\Hydrator\Strategy\HasOneStrategy;
use Strapieno\NightClub\Model\Entity\Object\GeoCoordinateObject;
use Strapieno\NightClub\Model\Entity\Object\MediaObject;
use Strapieno\NightClub\Model\Entity\Object\PostalAddressObject;
use Strapieno\Utils\DataStructure\RefIdentityCollection;
use Strapieno\Utils\Hydrator\DateHystoryHydrator;

/**
 * Class NightClubHydrator
 */
class NightClubHydrator extends DateHystoryHydrator
{
    public function __construct($underscoreSeparatedKeys = true)
    {
        parent::__construct($underscoreSeparatedKeys);
        $this->addStrategy(
            'geo_coordinate',
            new HasOneStrategy(new GeoCoordinateObject(), false)
        );
        $this->addStrategy(
            'postal_address',
            new HasOneStrategy(new PostalAddressObject(), false)
        );
        $this->addStrategy(
            'media',
            // FIXME library 2 param type function
            new HasManyStrategy(new MediaObject(), new RefIdentityCollection(), true)
        );
    }
}