<?php

namespace AppBundle\Controller;

use AppBundle\Entity\members;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class adminController extends Controller {




    /**
     * @Route("/form", name="form")
     */
    public function createFormAction(Request $request) {
        $members = new members();
        $form = $this->createFormBuilder($members)
                ->add('image', FileType::class, array('attr' => array('style' => 'margin-bottom:15px')))
                ->add('title', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
                ->add('description', TextareaType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
                ->add('date', DateType::class, array('attr' => array('class' => 'formcontrol', 'style' => 'margin-bottom:15px')))
                ->add('save', SubmitType::class, array('label' => 'Create Event', 'attr' => array('class' => 'btn btn-primary', 'style' => 'margin-bottom:15px')))
                ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $members->upload();
            $title = $form['title']->getData();
            $description = $form['description']->getData();
            $date = $form['date']->getData();

            $members->setTitle($title);
            $members->setDescription($description);
            $members->setDate($date);
            $em = $this->getDoctrine()->getManager();
            $em->persist($members);
            $em->flush();

            $this->addFlash(
                    'notice', 'Event Added!!'
            );
            return $this->redirectToRoute('members_index');
        }
        return $this->render('admin/create.html.twig', [
                    'form' => $form->createView()
        ]);
    }


    //
    // /**
    //  * @Route("/dev/view/{id}", name="view")
    //  * @param type $id
    //  */
    // public function viewAction($id) {
    //
    //     $member = $this->getDoctrine()
    //             ->getRepository('AppBundle:members')
    //             ->find($id);
    //     return $this->render('admin/view.html.twig', [
    //                 'member' => $member
    //     ]);
    // }
    //
    // /**
    //  * @Route("dev/edit/{id}", name="edit")
    //  */
    // public function editAction($id, Request $request) {
    //     $member = $this->getDoctrine()
    //             ->getRepository('AppBundle:members')
    //             ->find($id);
    //     $member->upload();
    //     $member->setTitle($member->getTitle());
    //     $member->setDescription($member->getDescription());
    //     $member->setDate($member->getDate());
    //
    //     $form = $this->createFormBuilder($member)
    //             ->add('image', FileType::class, array('attr' => array('style' => 'margin-bottom:15px')))
    //             ->add('title', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
    //             ->add('description', TextareaType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px;resize:none')))
    //             ->add('date', DateType::class, array('attr' => array('class' => 'formcontrol', 'style' => 'margin-bottom:15px')))
    //             ->add('save', SubmitType::class, array('label' => 'Edit Event', 'attr' => array('class' => 'btn btn-primary', 'style' => 'margin-bottom:15px')))
    //             ->getForm();
    //     $form->handleRequest($request);
    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $member->upload();
    //         $title = $form['title']->getData();
    //         $description = $form['description']->getData();
    //         $date = $form['date']->getData();
    //
    //         $em = $this->getDoctrine()->getManager();
    //         $member = $em->getRepository('AppBundle:members')->find($id);
    //
    //         $member->setTitle($title);
    //         $member->setDescription($description);
    //         $member->setDate($date);
    //
    //         $em->flush();
    //
    //         $this->addFlash(
    //                 'notice', 'Edited Successfully!!'
    //         );
    //         $this->redirectToRoute('dev');
    //     }
    //     return $this->render('admin/edit.html.twig', [
    //                 'form' => $form->createView()
    //     ]);
    // }
    //
    // /**
    //  * @Route("dev/delete/{id}",name="delete")
    //  * @param type $id
    //  */
    // public function deleteAction($id) {
    //
    //     $em = $this->getDoctrine()->getManager();
    //     $member = $em->getRepository('AppBundle:members')->find($id);
    //
    //     $em->remove($member);
    //     $em->flush();
    //
    //     $this->addFlash(
    //             'notice', 'Deleted Successfully!!'
    //     );
    //     return $this->redirectToRoute('dev');
    // }
    //
    // /**
    //  * @Route("/createPortfolio", name="createPortfolio")
    //  */
    // public function createPortfolioAction(Request $request) {
    //
    //     $img_path = new portfolio();
    //     $portfolio_name = $this->createFormBuilder($img_path)
    //             ->add('imgpath', FileType::class, array('label'=>'Image','attr' => array('id' => 'file')))
    //             ->add('name', TextType::class)
    //             ->add('role', TextType::class)
    //             ->add('submit', SubmitType::class, array('attr' => array('class' => 'btn btn-primary')))
    //             ->getForm()
    //     ;
    //     $portfolio_name->handleRequest($request);
    //     if ($portfolio_name->isSubmitted() && $portfolio_name->isValid()) {
    //
    //         $img_path->Upload();
    //         $name = $portfolio_name['name']->getData();
    //         $role = $portfolio_name['role']->getData();
    //         $img_path->setName($name);
    //         $img_path->setRole($role);
    //         $em = $this->getDoctrine()->getManager();
    //         $em->persist($img_path);
    //         $em->flush();
    //
    //         $this->addFlash('notice', 'Portfolio added successfully!!');
    //         return $this->redirectToRoute('createPortfolio');
    //     }
    //
    //     return $this->render('admin/createPortfolio.html.twig', [
    //                 'form_portfolio' => $portfolio_name->createView()
    //     ]);
    // }

}
