<?php

namespace App\Controller;

use App\Repository\CustomerRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Customer;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\CustomerSearch;
use App\Form\CustomerSearchType;

/**
 * @Route("/app/customers")
 */
class CustomerController extends AbstractController
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
     * @route("/", name="customer.index")
     * @return Response
     */
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        $search = new CustomerSearch();
        $form = $this->createForm(CustomerSearchType::class, $search);
        $form->handleRequest($request);

        $customers = $paginator->paginate(
            $this->repository->findAllVisibleQuery($search),
            $request->query->getInt('page', 1),
            12
        );

        return $this->render('front/customer/index.html.twig', [
            'current_menu' => 'customers',
            'customers' => $customers,
            'form' => $form->createView()
        ]);
    }

    /**
     * @route("/{slug}-{id}", name="customer.show", requirements={"slug": "[a-z0-9\-]*"})
     * @return Response
     */
    public function show(Customer $customer, string $slug): Response
    {
        if ($customer->getSlug() !== $slug) {
            return $this->redirectToRoute('customer.show', [
                'id' => $customer->getId(),
                'slug' => $customer->getSlug()
            ], 301);
        }
        return $this->render('front/customer/show.html.twig', [
            'customer' => $customer,
            'current_menu' => 'customers'
        ]);
    }
}
