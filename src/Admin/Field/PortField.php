<?php

namespace App\Admin\Field;

use App\Component\Form\Extension\Core\Type\PortType;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;

final class PortField implements FieldInterface
{
    use FieldTrait;

    public static function new(string $propertyName, ?string $label = null)
    {
        return (new self())
            ->setProperty($propertyName)
            ->setLabel($label)
            ->setTemplateName('crud/field/integer')
            ->setFormType(PortType::class)
            ->addCssClass('field-port')
            ->setHelp('Choose value between 0-65535');
    }
}