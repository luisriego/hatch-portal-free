<?php

namespace App\Controller\Admin;

use App\Entity\Area;
use App\Entity\Blog;
use App\Entity\Event;
use App\Entity\News;
use App\Entity\Project;
use App\Entity\Topic;
use App\Entity\Type;
use App\Entity\User;
use App\Repository\DoctrineTopicRepository;
use App\Repository\ProjectRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    public function __construct(
        private readonly ProjectRepository $projectRepository,
        private readonly DoctrineTopicRepository $topicRepository,
    )
    {
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/admin', name: 'admin_dashboard')]
    public function index(): Response
    {
//        return parent::index();
        return $this->render('admin/index.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Hatch Innovation Brazil')
            ->setLocales(['en', 'pt_BR']);
    }

    public function configureMenuItems(): iterable
    {
        $numProjects = $this->projectRepository->getTotalNumber();
        $numTopics = $this->topicRepository->getTotalNumber();
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-dashboard');
        yield MenuItem::section('Admin');
        yield MenuItem::linkToCrud('Projects', 'fas fa-gear', Project::class)
            ->setBadge($numProjects, 'secondary');
        yield MenuItem::linkToCrud('Topics', 'fas fa-folder', Topic::class)
            ->setBadge($numTopics, 'secondary');
        yield MenuItem::linkToCrud('Users', 'fas fa-users', User::class);
        yield MenuItem::section('Admin data');
        yield MenuItem::linkToCrud('Area', 'fa fa-square', Area::class);
        yield MenuItem::linkToCrud('Type', 'fa fa-check-square', Type::class);
        yield MenuItem::section('Homepage data');
        yield MenuItem::linkToCrud('Events', 'fa fa-meetup', Event::class);
        yield MenuItem::linkToCrud('News', 'fa fa-newspaper-o', News::class);
        yield MenuItem::linkToCrud('Blogs', 'fa fa-blog', Blog::class);
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
        yield MenuItem::section('Links');
        yield MenuItem::linkToUrl('Homepage', 'fas fa-home', $this->generateUrl('app_homepage'));
    }

    public function configureActions(): Actions
    {
        return parent::configureActions()
            ->add(Crud::PAGE_INDEX, Action::DETAIL); // TODO: Change the autogenerated stub
    }
}
