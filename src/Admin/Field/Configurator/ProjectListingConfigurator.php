<?php

namespace App\Admin\Field\Configurator;

use App\Admin\Field\ProjectListingField;
use App\Controller\Admin\ProjectCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldConfiguratorInterface;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\FieldDto;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;

final class ProjectListingConfigurator implements FieldConfiguratorInterface
{
    private $adminUrlGenerator;

    public function __construct(AdminUrlGenerator $adminUrlGenerator)
    {
        $this->adminUrlGenerator = $adminUrlGenerator;
    }

    public function supports(FieldDto $field, EntityDto $entityDto): bool
    {
        return ProjectListingField::class === $field->getFieldFqcn();
    }

    public function configure(FieldDto $field, EntityDto $entityDto, AdminContext $context): void
    {
        $url = $this->adminUrlGenerator
            ->setController(ProjectCrudController::class)
            ->setAction(Action::INDEX)
            ->set('clientId', $entityDto->getPrimaryKeyValue())
            ->generateUrl();

        $field->setCustomOption(ProjectListingField::PROJECTS_URL, $url);
    }
}