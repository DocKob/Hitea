<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\CustomerRepository;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Customer;
use App\Form\CustomerType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * @Route("manage/customers")
 */
class AdminCustomerController extends AbstractController
{

    /**
     * @var CustomerRepository
     */
    private $repository;

    /**
     * @var ObjectManager
     */
    private $em;

    public function __construct(CustomerRepository $repository, ObjectManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @route("/", name="admin.customer.index")
     */
    public function index()
    {
        $customers = $this->repository->findAll();
        return $this->render('front/customer/index_table.html.twig', compact('customers'));
    }

    /**
     * @route("/new", name="admin.customer.new")
     */
    public function new(Request $request)
    {
        $customer = new Customer();
        $form = $this->createForm(CustomerType::class, $customer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($customer);
            $this->em->flush();
            $this->addFlash('success', 'Create Success');
            return $this->redirectToRoute('admin.customer.index');
        }

        return $this->render('front/customer/new.html.twig', [
            'customer' => $customer,
            'form' => $form->createView()
        ]);
    }

    /**
     * @route("/{id}/edit", name="admin.customer.edit", methods="GET|POST")
     */
    public function edit(Customer $customer, Request $request)
    {
        $form = $this->createForm(CustomerType::class, $customer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash('success', 'Edit Success');
            return $this->redirectToRoute('admin.customer.index');
        }

        return $this->render('front/customer/edit.html.twig', [
            'customer' => $customer,
            'form' => $form->createView()
        ]);
    }

    /**
     * @route("/{id}", name="admin.customer.delete", methods="DELETE")
     */
    public function delete(Customer $customer, Request $request)
    {
        if ($this->isCsrfTokenValid('delete' . $customer->getId(), $request->get('_token'))) {
            $this->em->remove($customer);
            $this->em->flush();
            $this->addFlash('success', 'Delete Success');
        }
        return $this->redirectToRoute('admin.customer.index');
    }
}
