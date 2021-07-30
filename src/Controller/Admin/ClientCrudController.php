<?php

namespace App\Controller\Admin;

use App\Admin\Field\ProjectListingField;
use App\Entity\Client;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;

class ClientCrudController extends AbstractCrudController
{
    private AdminUrlGenerator $adminUrlGenerator;

    public function __construct(AdminUrlGenerator $adminUrlGenerator)
    {
        $this->adminUrlGenerator = $adminUrlGenerator;
    }

    public static function getEntityFqcn(): string
    {
        return Client::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        $url = $this->adminUrlGenerator
            ->setController(ProjectCrudController::class)
            ->setEntityId(1)
            ->generateUrl();

        $viewProjects = Action::new('View projects')
            ->displayIf(fn(Client $client) => $client->hasProject())
            ->linkToUrl($url);

        return $actions
            ->add(Crud::PAGE_INDEX, $viewProjects);
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name');
        yield AssociationField::new('type')->setRequired(true);

        yield ProjectListingField::new('countProject', 'Projects')
            ->setVirtual(true)
            ->onlyOnIndex();
    }


}
