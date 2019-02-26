<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 */
class AdminDashboardController extends AbstractController
{

    public function __construct()
    { }

    /**
     * @route("/", name="admin.dashboard.index")
     */
    public function index()
    {
        return $this->render('admin.html.twig');
    }
}

