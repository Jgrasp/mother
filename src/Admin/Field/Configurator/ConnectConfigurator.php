<?php

namespace App\Admin\Field\Configurator;

use App\Admin\Field\ConnectField;
use App\Entity\Access;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldConfiguratorInterface;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\FieldDto;

class ConnectConfigurator implements FieldConfiguratorInterface
{
    public function supports(FieldDto $field, EntityDto $entityDto): bool
    {
        return ConnectField::class == $field->getFieldFqcn() && $entityDto->getInstance() instanceof Access;
    }

    public function configure(FieldDto $field, EntityDto $entityDto, AdminContext $context): void
    {
        /**
         * @var Access $access
         */
        $access = $entityDto->getInstance();

        $field->setCustomOption('url', $access->getUrl());
        $field->setCustomOption('username', $access->getUsername());
        $field->setCustomOption('password', $access->getPassword());

        $type = strtolower($access->getType()->getName());

        if ($type == 'back-office') {

            if ($access->hasFramework()) {
                $framework = strtolower($access->getFrameworkVersion()->getFramework()->getName());
                if ($framework == 'prestashop') {
                    $field->setTemplatePath('admin/field/connect/prestashop_back_office.html.twig');
                }
            }

        }

    }

}