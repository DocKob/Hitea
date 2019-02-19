<?php

namespace App\Controller\Admin;

use App\Entity\Tag;
use App\Form\TagType;
use App\Repository\TagRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/tag")
 */
class AdminTagController extends AbstractController
{
    /**
     * @Route("/", name="admin.tag.index", methods={"GET"})
     */
    public function index(TagRepository $tagRepository) : Response
    {
        return $this->render('admin/tag/index.html.twig', ['tags' => $tagRepository->findAll()]);
    }

    /**
     * @Route("/new", name="admin.tag.new", methods={"GET","POST"})
     */
    public function new(Request $request) : Response
    {
        $tag = new Tag();
        $form = $this->createForm(TagType::class, $tag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($tag);
            $entityManager->flush();
            $this->addFlash('success', 'Create Success');

            return $this->redirectToRoute('admin.tag.index');
        }

        return $this->render('admin/tag/new.html.twig', [
            'tag' => $tag,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin.tag.edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Tag $tag) : Response
    {
        $form = $this->createForm(TagType::class, $tag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Edit Success');
            return $this->redirectToRoute('admin.tag.index', ['id' => $tag->getId()]);
        }

        return $this->render('admin/tag/edit.html.twig', [
            'tag' => $tag,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin.tag.delete", methods={"DELETE"})
     */
    public function delete(Request $request, Tag $tag) : Response
    {
        if ($this->isCsrfTokenValid('delete' . $tag->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($tag);
            $entityManager->flush();
            $this->addFlash('success', 'Delete Success');
        }

        return $this->redirectToRoute('admin.tag.index');
    }
}