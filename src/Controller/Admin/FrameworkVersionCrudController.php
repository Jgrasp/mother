<?php

namespace App\Controller\Admin;

use App\Entity\FrameworkVersion;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Config\Option\SortOrder;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class FrameworkVersionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return FrameworkVersion::class;
    }


    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('framework')
            ->add('value');
    }

    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('framework')
            ->setRequired(true)
            ->setQueryBuilder(fn(QueryBuilder $builder) => $builder->addOrderBy('entity.name', SortOrder::ASC));
        yield TextField::new('value', 'Version');
    }

}
