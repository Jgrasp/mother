<?php

namespace App\Controller\Admin;

use App\Entity\Access;
use App\Entity\AccessType;
use App\Entity\Client;
use App\Entity\ClientType;
use App\Entity\Environment;
use App\Entity\Framework;
use App\Entity\Project;
use App\Entity\Protocol;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route(path: '/admin', name: 'admin')]
    public function index(): Response
    {
        $routeBuilder = $this->get(CrudUrlGenerator::class)->build();
        $url = $routeBuilder->setController(ClientCrudController::class)->generateUrl();

        return $this->redirect($url);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Mother');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToRoute('Back to the website', 'fas fa-home', 'homepage');

        yield MenuItem::section('Company');
        yield MenuItem::linkToCrud('Clients', 'fa fa-building', Client::class);
        yield MenuItem::linkToCrud('Projects', 'fa fa-project-diagram', Project::class);

        yield MenuItem::section('Configure');
        yield MenuItem::subMenu('Client')->setSubItems([
            MenuItem::linkToCrud('Clients type', null, ClientType::class)
        ]);

        yield MenuItem::subMenu('Projects')->setSubItems([
            MenuItem::linkToCrud('Frameworks', null, Framework::class),
            MenuItem::linkToCrud('Environment', null, Environment::class),
            MenuItem::linkToCrud('Protocol', null, Protocol::class),
            MenuItem::linkToCrud('Access type', null, AccessType::class),
        ]);
    }
}
