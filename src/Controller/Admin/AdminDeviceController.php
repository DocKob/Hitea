<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\DeviceRepository;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Device;
use App\Form\DeviceType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;


class AdminDeviceController extends AbstractController
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
     * @route("/admin", name="admin.device.index")
     */
    public function index()
    {
        $devices = $this->repository->findAll();
        return $this->render('admin/device/index.html.twig', compact('devices'));
    }

    /**
     * @route("/admin/device/create", name="admin.device.new")
     */
    public function new(Request $request)
    {
        $device = new Device();
        $form = $this->createForm(DeviceType::class, $device);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($device);
            $this->em->flush();
            $this->addFlash('success', 'Create Success');
            return $this->redirectToRoute('admin.device.index');
        }

        return $this->render('admin/device/new.html.twig', [
            'device' => $device,
            'form' => $form->createView()
        ]);
    }

    /**
     * @route("/admin/device/{id}", name="admin.device.edit", methods="GET|POST")
     */
    public function edit(Device $device, Request $request)
    {
        $form = $this->createForm(DeviceType::class, $device);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash('success', 'Edit Success');
            return $this->redirectToRoute('admin.device.index');
        }

        return $this->render('admin/device/edit.html.twig', [
            'device' => $device,
            'form' => $form->createView()
        ]);
    }

    /**
     * @route("/admin/device/{id}", name="admin.device.delete", methods="DELETE")
     */
    public function delete(Device $device, Request $request)
    {
        if ($this->isCsrfTokenValid('delete' . $device->getId(), $request->get('_token'))) {
            $this->em->remove($device);
            $this->em->flush();
            $this->addFlash('success', 'Delete Success');
        }
        return $this->redirectToRoute('admin.device.index');
    }

}