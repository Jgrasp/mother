<?php

namespace App\Controller\Admin;

use App\Entity\Project;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Config\Option\SortOrder;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;

class ProjectCrudController extends AbstractCrudController
{
    private AdminUrlGenerator $adminUrlGenerator;

    public function __construct(AdminUrlGenerator $adminUrlGenerator)
    {
        $this->adminUrlGenerator = $adminUrlGenerator;
    }

    public static function getEntityFqcn(): string
    {
        return Project::class;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('client')
            ->add('name');
    }

    public function configureActions(Actions $actions): Actions
    {
        $viewAccesses = Action::new('Accesses')
            ->linkToCrudAction('displayAccesses');

        return $actions
            ->add(Crud::PAGE_INDEX, $viewAccesses);
    }

    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('client')
            ->setRequired(true)
            ->setQueryBuilder(fn(QueryBuilder $builder) => $builder->addOrderBy('entity.name', SortOrder::ASC));
        yield TextField::new('name', 'Name');
    }

    public function displayAccesses(AdminContext $context)
    {
        $url = $this->adminUrlGenerator
            ->setController(AccessCrudController::class)
            ->setAction(Action::INDEX)
            ->set('filters[project][comparison]', '=')
            ->set('filters[project][value]', $context->getEntity()->getPrimaryKeyValue())
            ->setEntityId(null)
            ->generateUrl();

        return $this->redirect($url);
    }

}
