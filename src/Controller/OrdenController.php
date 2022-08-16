<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Orden;
use App\Entity\Estadotrabajo;
use App\Entity\Comprobante;
use App\Entity\Items;
use App\Entity\Pago;
use App\Entity\Tipodepago;
use App\Form\PagoType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Dompdf\Dompdf;
use Dompdf\Options;


/**
 * Description of OrdenController
 *
 * @author maricle
 */
class OrdenController extends EasyAdminController {

    /**
     * @Route(path = "/admin/orden/cambiarestado", name = "orden_cambiarestado")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function ordenCambiarestadoAction(Request $request) {
        // controllers extending the base AdminController get access to the
        // following variables:

        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository(Orden::class);
        //obtego la orden en ncuestion, consulto si esta e estado finalizado no hago nada

        $id = $request->query->get('id');
        $orden = $repository->find($id);
        //echo $orden->getEstadotrabajo();die;
        if (is_null($orden->getEstadotrabajo()) or ( $orden->getEstadotrabajo() <> 'Finalizado')) {
            $estadosrep = $this->getDoctrine()->getRepository(Estadotrabajo::class);

            $next_estado = $estadosrep->findNextEstado($orden->getEstadotrabajo());

            $orden->ActualizarEstado($next_estado);
            $em->flush();

            // redirect to the 'list' view of the given entity ...
            return $this->redirectToRoute('easyadmin', array(
                        'action' => 'list',
                        'entity' => 'Ordenes',
            ));
        } else {
            $message = 'El trabajo ya fue finalizado puede eviarlo a oficina o entregarlo al cliente, seleccionando la casilla a la derecha';

            $this->addFlash('warning', $message);
            return $this->redirectToRoute('easyadmin', array(
                        'action' => 'list',
                        'entity' => 'Ordenes',
            ));
        }
        // ... or redirect to the 'edit' view of the given entity item
//        return $this->redirectToRoute('easyadmin ', array(
//            'action' => 'edit',
//            'id' => $id,
//            'entity' => $this->request->query->get('entity'),
//        ));
    }

    /**
     * @Route(path = "/admin/orden/cambiarestadoAnterior", name = "orden_cambiarestado_ant")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function ordenCambiarestadoAnteriorAction(Request $request) {
        // controllers extending the base AdminController get access to the
        // following variables:
        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository(Orden::class);
        $estadosrep = $this->getDoctrine()->getRepository(Estadotrabajo::class);
        $next_estado = null;
        $id = $request->query->get('id');
        $orden = $repository->find($id);

        $next_estado = $estadosrep->findNextEstado($orden->getEstadotrabajo());

        $orden->ActualizarEstado($next_estado);

        $em->flush();
        return new JsonResponse(['estado' => $next_estado]);

        // redirect tthe 'list' view of the given entity ...
        return $this->redirectToRoute('easyadmin', array(
                    'action' => 'list',
                    'entity' => 'Ordenes',
        ));
    }

    /**
     * @Route("/admin/orden/cambiarestado/{id}", name="orden_cambiar_estado", methods="POST")
     */
    public function ordenCambiarEstado($id) {
        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository(Orden::class);
        $estadosrep = $this->getDoctrine()->getRepository(Estadotrabajo::class);
        $next_estado = null;
        //$id = quest->query->get('id');
        $orden = $repository->find($id);

        $next_estado = $estadosrep->findNextEstado($orden->getEstadotrabajo());

        $orden->ActualizarEstado($next_estado);
        $em->flush();
        return new JsonResponse(['estado' => $next_estado->getDescripcion()]);
    }

    /**
     * @Route(path = "/admin/orden/termianda", name = "orden_terminada")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function ordenTerminadaAction(Request $request) {
        // controllers extending the base AdminController get access to the
        // following variables:s
        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository(Orden::class);
        $estadosrep = $this->getDoctrine()->getRepository(Estadotrabajo::class);

        $id = $request->query->get('id');
        $orden = $repository->find($id);
        $next_estado = $estadosrep->findOneBy(['descripcion' => 'Terminado']);
        $orden->setEstadotrabajo($next_estado);
        $orden->setTerminado(new \DateTime("Now"));
        $em->flush();
        $message = 'La orden fue enviada al listado de treminadas';
        $this->addFlash('success', $message);
        return $this->redirectToRoute('easyadmin', array(
                    'action' => 'list',
                    'entity' => 'Ordenes',
        ));
    }

    /**
     * @Route(path = "/admin/orden/registrarpago/{id}", name = "registrar_pago", methods="POST")
     *  
     */
    public function registrarPago($id) {

        // controllers extending the base AdminController get access to the
        // following variables:s
        $em = $this->getDoctrine()->getManagerForClass(Pago::class);
        $em2 = $this->getDoctrine()->getManagerForClass(Orden::class);
        $repository = $this->getDoctrine()->getRepository(Orden::class);
        $rep_tiposdepago = $this->getDoctrine()->getRepository(Tipodepago::class);
        $estadosrep = $this->getDoctrine()->getRepository(Estadotrabajo::class);

        // $id = $request->query->get('id');
        $orden = $repository->find($id);
        //$orden->updateSaldo();s
        //echo $orden->getSaldo(); die;
        if ($orden->getSaldo() > 0):
            $pago = new Pago();
            $pago->setDescripcion('Pago en efectivo.');
            $pago->setFecha(new \DateTime("Now"));
            $pago->setPersona($orden->getPersona());
            $pago->setValor($orden->getSaldo());
            $pago->setOrden($orden);
            $tipop = $rep_tiposdepago->find(1);
            $pago->setTipodepago($tipop);

            //$pago->addPago($pago);
            $em->persist($pago);
            $orden->setSaldo(0);
            if ($orden->getEstadotrabajo()->getId() >= 5) {
                $next_estado = $estadosrep->find(9);
                $orden->ActualizarEstado($next_estado);
            }
            $em2->persist($orden);

            $em->flush();
            $em2->flush();
            $message = 'EL pago se registro Correctamente el pago de la orden Nro' . $orden->getId() . ' : $' . $pago->getValor();
            $this->addFlash('success', $message);
        else :
            $message = 'La orden Nro ' . $orden->getId() . ' ya esta saldada';
            $this->addFlash('warning', $message);
        endif;


//        return $this->redirectToRoute('easyadmin', array(
//                    'action' => 'list',
//                    'id' => $pago->getId(),
//                    'entity' => 'Ordenes',
//        ));
        return new JsonResponse(['estado' => 'pagado']);
    }

//    ==============================================================================
//    BATCH ACTIONS

    /**
     * @Route(path = "/admin/orden/facturarorden", name = "facturarorden")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function facturarOrdenBatchAction(array $ids) {
        $class = $this->entity['class'];
        $em = $this->getDoctrine()->getManagerForClass($class);

        $factura = new Comprobante();
        //$factura->setPersona($orden->getPersona());
        $factura->setFecha(getdate());
        $factura->setTipo(false);
        $factura->setCompra(false);
        $factura->setPuntodeventa(1);
        $total = 0;
        //$factura->set
        $cliente = null;
        foreach ($ids as $id) {
            if (!$cliente) {
                $factura->setPersona($orden->getPersona());
            } else {
                return $this->redirectToRoute('easyadmin', array(
                            'action' => 'list',
                            'entity' => 'Ordenes',
                ));
            }
            $item = new Items();

            $repository = $this->getDoctrine()->getRepository(Orden::class);
            $orden = $repository->find($id);
            $item->setOrden($orden);
            $item->setDescripcion($orden->getNombre());
            $item->setPrecio($orden->getPrecio());
            $total += $orden->getPrecio();
            $item->setComprobante($factura);
        }

        $this->em->flush();
        $message = 'La factura se creo';
        $this->addFlash('success', $message);

        // don't return anything or redirect to any URL because it will be ignored
        // when a batch action finishes, user is redirected to the original page
    }

    /**
     * @Route(path = "/admin/orden/recibirorden", name = "recibirorden")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function recibirOrdenBatchAction(array $ids) {
        $class = $this->entity['class'];
        $em = $this->getDoctrine()->getManagerForClass($class);
        $cantidad = 0;
        $total = count($ids);
        $estadosrep = $this->getDoctrine()->getRepository(Estadotrabajo::class);
        $estado = $estadosrep->findOneBy(['descripcion' => 'Recibido en Oficina']);

        foreach ($ids as $id) {

            $repository = $this->getDoctrine()->getRepository(Orden::class);
            $orden = $repository->find($id);
            $orden->setEstadotrabajo($estado);
            if ($em->flush()) {
                $cantidad += 1;
            }
        }
    }

    /**
     * @Route(path = "/admin/orden/enviarorden", name = "enviarorden")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function enviarOrdenBatchAction(array $ids) {
        $class = $this->entity['class'];
        $em = $this->getDoctrine()->getManagerForClass($class);
        $cantidad = 0;
        $total = count($ids);
        $estadosrep = $this->getDoctrine()->getRepository(Estadotrabajo::class);
        $estado = $estadosrep->findOneBy(['descripcion' => 'Enviado a Oficina']);

        foreach ($ids as $id) {

            $repository = $this->getDoctrine()->getRepository(Orden::class);
            $orden = $repository->find($id);
            $orden->setEstadotrabajo($estado);
            if ($em->flush()) {
                $cantidad += 1;
            }
        }
    }

    /**
     * @Route(path = "/admin/orden/entregartrabajo", name = "entregartrabajo")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function entregarTrabajoBatchAction(array $ids) {
        $class = $this->entity['class'];
        $em = $this->getDoctrine()->getManagerForClass($class);
        $cantidad = 0;
        $total = count($ids);
        $estadosrep = $this->getDoctrine()->getRepository(Estadotrabajo::class);


        foreach ($ids as $id) {

            $repository = $this->getDoctrine()->getRepository(Orden::class);
            $orden = $repository->find($id);
            //if ($orden->getSaldo() == 0) {
             //   $estado = $estadosrep->findOneBy(['descripcion' => 'Entregado_P']);
            //} else {
                $estado = $estadosrep->findOneBy(['descripcion' => 'Entregado']);
            //}
            $orden->ActualizarEstado($estado);
            $orden->setEntregado(new \DateTime("Now"));
            if ($em->flush()) {
                $cantidad += 1;
            }
        }

        $message = 'Se registro la entrega de la/s orden/es:' . implode(',', $ids) . ', debe registrar los PAGOS.';
        $this->addFlash('success', $message);
        return $this->redirectToRoute('easyadmin', array(
                    'action' => 'list',
                    'entity' => 'Ordenes',
        ));
    }

    /**
     * @Route(path = "/admin/orden/entregartrabajopagado", name = "entregartrabajopagado")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function entregarTrabajoPagadoBatchAction(array $ids) {
        $class = $this->entity['class'];
        $em = $this->getDoctrine()->getManagerForClass($class);
        $cantidad = 0;
        $total = count($ids);
        $estadosrep = $this->getDoctrine()->getRepository(Estadotrabajo::class);
        $estado = $estadosrep->findOneBy(['descripcion' => 'Entregado_P']);
        $rep_tiposdepago = $this->getDoctrine()->getRepository(Tipodepago::class);
        $em2 = $this->getDoctrine()->getManagerForClass(Pago::class);

        foreach ($ids as $id) {

            $repository = $this->getDoctrine()->getRepository(Orden::class);
            $orden = $repository->find($id);
            $orden->setEstadotrabajo($estado);

            if ($orden->getSaldo() == 0) {
                
            } else {
                $pago = new Pago();
                $pago->setDescripcion('Pago en efectivo.');
                $pago->setFecha(new \DateTime("Now"));
                $pago->setPersona($orden->getPersona());
                $pago->setValor($orden->getSaldo());
                $pago->setOrden($orden);
                $tipop = $rep_tiposdepago->find(1);
                $pago->setTipodepago($tipop);
                $em2->persist($pago);
                $orden->setSaldo(0);
            }
            $em->persist($orden);
            if ($em->flush()) {
                $cantidad += 1;
            }





            $em->flush();
            $em2->flush();
        }

        $message = 'Se registro la entrega de  la/s orden/es ' . implode(',', $ids) . ' pagos correnpondientes';
        $this->addFlash('success', $message);
        return $this->redirectToRoute('easyadmin', array(
                    'action' => 'list',
                    'entity' => 'Ordenes',
        ));
    }

    /**
     * @Route(path="/admin/orden/{$slug}/producto", name="producto_get_precio")
     */
    public function ajaxGetPrecio() {
        return new JsonResponse(['precio' => rand(500, 1000)]);
    }

    /**
     * @Route(path = "/admin/orden/ordenprint", name = "ordenprint")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function ordenPrintAction(Request $request) {
        // controllers extending the base AdminController get access to the
        // following variables:
        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository(Orden::class);
        $id = $request->query->get('id');
        $orden = $repository->find($id);
        //Configurar pdf
        //flush();
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Roboto');
        $pdfOptions->setIsRemoteEnabled(true);
       // $pdfOptions->setRootDir($_SERVER['DOCUMENT_ROOT']);
        //Instanciar pdf
                
        $dompdf = new Dompdf($pdfOptions);
        //$dompdf->removeTextNodes();
        
        //asignar el HTML
        $html = $this->renderView('orden_admin/print_orden.html.twig', [ 
            'titulo'=> 'Orden Nro'. $orden->getId(),
            'fecha' =>$orden->getFecha(),
            'orden' => $orden,]);
        
        $dompdf->loadHtml($html);
        
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();        
        $dompdf->stream('Orden'.$orden->getId().'.pdf', ['Attachment'=>true]);
        exit();
        //throw new sfStopException();
        // the template path is the relative file path from `templates/`
       // return $this->render('orden_admin/print_orden.html.twig', [
                    // this array defines the variables passed to the template,
                    // where the key is the variable name and the value is the variable value
                    // (Twig recommends using snake_case variable names: 'foo_bar' instead of 'fooBar')
         //           'orden' => $orden,
        //]);
    }

    /**
     * @Route(path = "/admin/orden/verpagos", name = "verpagos")
     */
    public function verordenesAction(Request $request) {
        // controllers extending the base AdminController get access to the
        // following variables:
        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository(Orden::class);
        $id = $request->query->get('id');
        $orden = $repository->find($id);


        // redirect to the 'list' view of the given entity ...
        return $this->redirectToRoute('easyadmin', array(
                    'action' => 'list',
                    'entity' => 'Pagos',
                    'query' => 'item.orden =' . $orden->id,
        ));
    }

   
    
    
}
