<?php

namespace App\Controller\Admin;

use App\Entity\SoftwareVersion;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
#[AdminDashboard(
    routePath: '/admin',   // this will be your dashboard URL
    routeName: 'admin'     // the route name for internal use
)]
class AdminDashboardController extends AbstractDashboardController
{
    public function __construct(private EntityManagerInterface $em)
    {
    }
    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Firmware Admin');
    }

    public function index(): \Symfony\Component\HttpFoundation\Response
    {
        // Get SoftwareVersion count
        $softwareCount = $this->em->getRepository(SoftwareVersion::class)->count([]);

        // Render a custom dashboard template
        return $this->render('admin/dashboard.html.twig', [
            'softwareCount' => $softwareCount,
        ]);
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToUrl('Software Versions', 'fa-solid fa-microchip', '/admin/software-version');
        yield MenuItem::linkToUrl('Users', 'fa-solid fa-users', '/admin/user');
    }
}
