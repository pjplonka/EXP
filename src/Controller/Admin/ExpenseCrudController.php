<?php

namespace App\Controller\Admin;

use App\Entity\Expense;
use DateTimeImmutable;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ExpenseCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Expense::class;
    }

    public function createEntity(string $entityFqcn) {
        $expense = new Expense();
        $expense->date = new DateTimeImmutable();
        $expense->isPaid = true;

        return $expense;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->hideOnForm();
        yield TextField::new('name');
        yield NumberField::new('amount');
        yield BooleanField::new('isPaid');
        yield AssociationField::new('labels')->setTemplatePath('admin/fields/labels.html.twig');
        yield DateField::new('date');
    }
}
