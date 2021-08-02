<?php

namespace App\Controller\Admin;

use App\Admin\Field\OpenField;
use App\Admin\Field\PortField;
use App\Entity\Access;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Config\Option\SortOrder;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class AccessCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Access::class;
    }


    public function configureFields(string $pageName): iterable
    {
        yield FormField::addPanel('Configuration');
        yield AssociationField::new('project')
            ->setRequired(true)
            ->setQueryBuilder(function (QueryBuilder $builder) {
                return $builder
                    ->join('entity.client', 'client')
                    ->addOrderBy('client.name', SortOrder::ASC)
                    ->addOrderBy('entity.name', SortOrder::ASC);
            });
        yield AssociationField::new('environment')
            ->setRequired(true)
            ->setQueryBuilder(fn(QueryBuilder $builder) => $builder->addOrderBy('entity.name', SortOrder::ASC));
        yield AssociationField::new('type')
            ->setRequired(true)
            ->onlyOnForms()
            ->setQueryBuilder(fn(QueryBuilder $builder) => $builder->addOrderBy('entity.name', SortOrder::ASC));


        yield FormField::addPanel('Host');
        yield AssociationField::new('protocol')
            ->setRequired(true)
            ->setQueryBuilder(fn(QueryBuilder $builder) => $builder->addOrderBy('entity.name', SortOrder::ASC));
        yield TextField::new('host');
        yield PortField::new('port');
        yield TextField::new('path');

        yield FormField::addPanel('Credentials');
        yield TextField::new('username');
        yield TextField::new('password');

        yield OpenField::new('Link')
            ->setVirtual(true)
            ->onlyOnIndex();
    }

}
