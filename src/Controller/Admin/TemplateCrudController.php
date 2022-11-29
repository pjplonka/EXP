<?php

namespace App\Controller\Admin;

use App\Entity\Expense;
use App\Entity\Template;
use App\Repository\ExpenseRepository;
use App\Repository\TemplateRepository;
use DateTimeImmutable;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\BatchActionDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\RedirectResponse;

class TemplateCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Template::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->hideOnForm();
        yield TextField::new('name');
        yield NumberField::new('amount');
        yield AssociationField::new('labels')->setTemplatePath('admin/fields/labels.html.twig');
    }

    public function copyToExpenses(
        BatchActionDto $batchActionDto,
        TemplateRepository $templates,
        ExpenseRepository $expenses,
        AdminUrlGenerator $adminUrlGenerator
    ): RedirectResponse {
        foreach ($batchActionDto->getEntityIds() as $id) {
            $template = $templates->find($id);

            $expense = new Expense();
            $expense->name = $template->name;
            $expense->amount = $template->amount;
            $expense->isPaid = false;
            $expense->date = new DateTimeImmutable();
            $expense->labels = $template->labels;

            $expenses->save($expense, true);
        }

        $url = $adminUrlGenerator
            ->setController(ExpenseCrudController::class)
            ->setAction('index')
            ->generateUrl();

        return $this->redirect($url);
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->addBatchAction(
                Action::new('copyToExpenses', 'Add to current month')
                    ->linkToCrudAction('copyToExpenses')
                    ->addCssClass('btn btn-secondary')
                    ->setIcon('fa fa-circle-up')
            );
    }
}
