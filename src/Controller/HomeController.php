<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\DeviceRepository;

class HomeController extends AbstractController
{

    /**
     * @route("/", name="home")
     * @return Response
     */
    public function index(DeviceRepository $repository) : Response
    {
        $devices = $repository->findLatest();

        return $this->render('pages/home.html.twig', [
            'devices' => $devices
        ]);
    }

}