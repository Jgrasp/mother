<?php

namespace App\Controller\Admin;

use App\Entity\Framework;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;

class FrameworkCrudController extends AbstractCrudController
{
    private AdminUrlGenerator $adminUrlGenerator;

    public function __construct(AdminUrlGenerator $adminUrlGenerator)
    {
        $this->adminUrlGenerator = $adminUrlGenerator;
    }

    public static function getEntityFqcn(): string
    {
        return Framework::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        $viewVersions = Action::new('View versions')
            ->linkToCrudAction('displayFrameworkVersions');

        return $actions
            ->add(Crud::PAGE_INDEX, $viewVersions);
    }

    public function displayFrameworkVersions(AdminContext $context): Response
    {
        $url = $this->adminUrlGenerator
            ->setController(FrameworkVersionCrudController::class)
            ->setAction(Action::INDEX)
            ->set('filters[framework][comparison]', '=')
            ->set('filters[framework][value]', $context->getEntity()->getPrimaryKeyValue())
            ->setEntityId(null)
            ->generateUrl();

        return $this->redirect($url);
    }

}
