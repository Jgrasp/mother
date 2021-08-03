<?php

namespace App\Controller\Admin;

use App\Admin\Field\ProjectListingField;
use App\Entity\Client;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use SebastianBergmann\CodeCoverage\Report\Text;
use Symfony\Component\HttpFoundation\Response;


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

    /*public function configureCrud(Crud $crud): Crud
    {
        return $crud->showEntityActionsAsDropdown();
    }*/

    public function configureActions(Actions $actions): Actions
    {
        $viewProjects = Action::new('View projects')
            ->displayIf(fn(Client $client) => $client->hasProject())
            ->linkToCrudAction('displayProjects');

        return $actions
            ->add(Crud::PAGE_INDEX, $viewProjects);
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name');
        yield AssociationField::new('type')->setRequired(true);

        yield IntegerField::new('countProject', 'Projects')
            ->setVirtual(true)
            ->onlyOnIndex();
    }


    public function displayProjects(AdminContext $context): Response
    {
        $url = $this->adminUrlGenerator
            ->setController(ProjectCrudController::class)
            ->setAction(Action::INDEX)
            ->set('filters[client][comparison]', '=')
            ->set('filters[client][value]', $context->getEntity()->getPrimaryKeyValue())
            ->setEntityId(null)
            ->generateUrl();

        return $this->redirect($url);
    }


}
