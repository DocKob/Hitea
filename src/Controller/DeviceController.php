<?php

namespace App\Controller;

use App\Repository\DeviceRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Device;

class DeviceController extends AbstractController
{

    /**
     * @var DeviceRepository
     */
    private $repository;

    /**
     * @var ObjectManager
     */
    private $em;

    public function __construct(DeviceRepository $repository, ObjectManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @route("/devices", name="device.index")
     * @return Response
     */
    public function index() : Response
    {
        $devices = $this->repository->findAllVisible();

        return $this->render('device/index.html.twig', [
            'current_menu' => 'devices'
        ]);
    }

    /**
     * @route("/devices/{slug}-{id}", name="device.show", requirements={"slug": "[a-z0-9\-]*"})
     * @return Response
     */
    public function show(Device $device, string $slug) : Response
    {
        if ($device->getSlug() !== $slug) {
            return $this->redirectToRoute('device.show', [
                'id' => $device->getId(),
                'slug' => $device->getSlug()
            ], 301);
        }
        return $this->render('device/show.html.twig', [
            'device' => $device,
            'current_menu' => 'devices'
        ]);
    }

}