<?php
namespace Strapieno\NightClub\Api\V1\Hydrator;

use Matryoshka\Model\Hydrator\Strategy\HasManyStrategy;
use Matryoshka\Model\Hydrator\Strategy\HasOneStrategy;
use Matryoshka\Model\Hydrator\Strategy\SetTypeStrategy;
use Strapieno\NightClub\Model\Entity\Object\AggregateRatingObject;
use Strapieno\NightClub\Model\Entity\Object\GeoCoordinateObject;
use Strapieno\NightClub\Model\Entity\Object\MediaObject;
use Strapieno\NightClub\Model\Entity\Object\PostalAddressObject;
use Strapieno\User\Model\Entity\Reference\UserReference;
use Strapieno\Utils\DataStructure\RefIdentityCollection;
use Strapieno\Utils\Hydrator\DateHystoryHydrator;
use Strapieno\Utils\Hydrator\Strategy\NamingStrategy\MapUnderscoreNamingStrategy;
use Strapieno\Utils\Hydrator\Strategy\ReferenceEntityCompressStrategy;

/**
 * Class NightClubHydrator
 */
class NightClubHydrator extends DateHystoryHydrator
{
    public function __construct($underscoreSeparatedKeys = true)
    {
        parent::__construct($underscoreSeparatedKeys);

        $this->setNamingStrategy(new MapUnderscoreNamingStrategy(['user_id  ' => 'userReference']));

        $this->addStrategy(
            'geo_coordinate',
            new HasOneStrategy(new GeoCoordinateObject(), false)
        );

        $aggregateRating = new AggregateRatingObject();
        $aggregateRating->getHydrator()->addStrategy('partial', new SetTypeStrategy('array', 'array'));
        $this->addStrategy(
            'aggregate_rating',
            new HasOneStrategy($aggregateRating, false)
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

        $this->addStrategy(
            'user_id',
            new ReferenceEntityCompressStrategy(new UserReference(), false)
        );
    }
}