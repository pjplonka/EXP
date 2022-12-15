<?php

namespace App\Controller\Admin;

use App\Entity\Expense;
use App\Entity\Label;
use App\Entity\Template;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('@EasyAdmin/page/content.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('EXP');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Labels', 'fa fa-tag', Label::class);
        yield MenuItem::linkToCrud('Current Month', 'fa fa-question-circle', Expense::class)
            ->setController(CurrentMonthCrudController::class);
        yield MenuItem::linkToCrud('Expenses', 'fa fa-question-circle', Expense::class);
        yield MenuItem::linkToCrud('Templates', 'fa fa-clipboard', Template::class);
    }
}
