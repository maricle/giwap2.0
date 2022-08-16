<?php
namespace App\Controller;

use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use App\Entity\Orden;

class AdminController extends EasyAdminController
{
     /**
     * @Route("/dashboard", name="admin_dashboard")
     */
    public function dashboardAction()
    {
        $em = $this->getDoctrine()->getManager();
        $ordenRepository = $em->getRepository(Orden::class);
        
        $ordenesTransito = $ordenRepository->findBy(['estadotrabajo' => 6]);
        $ordenesRecibidas = $ordenRepository->findBy(['estadotrabajo' => 7]);
         $currentDate = new \DateTime();
        $ordenesHoy = $ordenRepository->findBy(['fecha'=> $currentDate]);
        
//        $ordenesPendientes = $ordenRepository->findBy(['estadotrabajo_id' =>'< 5']);
        return $this->render('easyadmin/dashboard.html.twig', [
            'ordenesCount' => count($ordenesRecibidas),
            'ordenesTransito' => count($ordenesTransito),
            'ordenesHoy'=> count($ordenesHoy),
            'cliente' =>  ['id'=>'110','name'=> 'Sosa', 'funFact'=>'Perez'],
            'ordenes'=> array_slice($ordenesHoy,-10,10),
        ]);
    } 
    

  
//    protected function getObjeto($entity, $id ) {
//        
//        $em = $this->getDoctrine()->getManager();
//        $repository = $this->getDoctrine()->getRepository($entity);
//        
//        return $repository->find($id);
//        
//        
//    }
    
    
    
//    public function changeStatusAction(array $ids)
//    {
//        $class = $this->entity['class'];
//        $em = $this->getDoctrine()->getManagerForClass($class);
//
//        foreach ($ids as $id) {
//            $user = $em->find($id);
//            $user->approve();
//        }
//
//        $this->em->flush();
//
//        // don't return anything or redirect to any URL because it will be ignored
//        // when a batch action finishes, user is redirected to the original page
//    }
    
// public function cambiarEstadodeordenAction()
//    {
//        // controllers extending the base AdminController get access to the
//        // following variables:
//        //   $this->request, stores the current request
//        //   $this->em, stores the Entity Manager for this Doctrine entity
//
//        // change the properties of the given entity and save the changes
//    // dump($this->request); die;
//        $id = $this->request->query->get('id');
//       // $entity = $this->request->query->get('entity');
//        $orden=  $this->em->getRepository(\App\Entity\Orden::class)->find($id);
//        $orden->setEstadotrabajo($this->em->getRepository(\App\Entity\Estadotrabajo::class)->find(2));
//        $this->em->flush();
//
//        // redirect to the 'list' view of the given entity ...
////        return $this->redirectToRoute('easyadmin', array(
////            'action' => 'list',
////            'entity' => $this->request->query->get('entity'),
////        ));
//
//        // ... or redirect to the 'edit' view of the given entity item
//        return $this->redirectToRoute('easyadmin', array(
//            'action' => 'edit',
//            'id' => $id,
//            'entity' => $this->request->query->get('entity'),
//        ));
//    }
//    
    
    
  
}