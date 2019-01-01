<?php

namespace App\Controller;

use App\Repository\DeviceRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Device;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\DeviceSearch;
use App\Form\DeviceSearchType;

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
    public function index(PaginatorInterface $paginator, Request $request) : Response
    {
        $search = new DeviceSearch();
        $form = $this->createForm(DeviceSearchType::class, $search);
        $form->handleRequest($request);

        $devices = $paginator->paginate(
            $this->repository->findAllVisibleQuery($search),
            $request->query->getInt('page', 1),
            12
        );

        return $this->render('front/device/index.html.twig', [
            'current_menu' => 'devices',
            'devices' => $devices,
            'form' => $form->createView()
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
        return $this->render('front/device/show.html.twig', [
            'device' => $device,
            'current_menu' => 'devices'
        ]);
    }

}