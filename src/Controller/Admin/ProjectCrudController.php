<?php

namespace App\Controller\Admin;

use App\Entity\Project;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Config\Option\SortOrder;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProjectCrudController extends AbstractCrudController
{
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

    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('client')
            ->setRequired(true)
            ->setQueryBuilder(fn(QueryBuilder $builder) => $builder->addOrderBy('entity.name', SortOrder::ASC));
        yield TextField::new('name', 'Name');
    }

}
