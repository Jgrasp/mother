<?php

namespace App\Component\Form\Extension\Core\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Range;

class PortType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('constraints', new Range([
            'min' => 0,
            'max' => 65535
        ]));
    }

    public function getParent()
    {
        return IntegerType::class;
    }

}