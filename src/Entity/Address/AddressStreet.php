<?php

namespace App\Entity\Address;
use App\Entity\RootEntity;
use App\EntityEmbeddable\ObjectProperty;
use App\EntityInterface\Address\AddressStreetInterface;
use App\EntityTrait\ObjectAuditTrait;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class AddressStreet extends RootEntity implements AddressStreetInterface
{
    use ObjectAuditTrait;
    #[ORM\Embedded(class: ObjectProperty::class)]
    private ObjectProperty $objectProperty;

    #[ORM\Column(name: 'addressStreet', type: 'string', unique: false, nullable: true, options: ['default' => 'Street'])]
    private string $addressStreet = 'Street';
}
