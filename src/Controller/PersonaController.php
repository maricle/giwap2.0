<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Orden;
use App\Entity\Persona;
use App\Entity\Comprobante;
use App\Entity\Items;
use App\Entity\Pago;
use App\Entity\Tipodepago;
use App\Form\PagoType;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Form\OrdenType;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\File\MimeType\FileinfoMimeTypeGuesser;

/**
 * Description of OrdenController
 *
 * @author maricle
 */
class PersonaController extends EasyAdminController {

    /**
     * @Route(path = "/admin/persona/verordenes", name = "verordenes")
     */
    public function verordenesAction(Request $request) {
        // controllers extending the base AdminController get access to the
        // following variables:
        $em = $this->getDoctrine()->getManager();
        $personas = $this->getDoctrine()->getRepository(Persona::class);
        $id = $request->query->get('id');
        $persona = $personas->find($id);

        // redirect to the 'list' view of the given entity ...
        return $this->redirectToRoute('easyadmin', array(
                    'action' => 'list',
                    'entity' => 'Ordenes',
                    'filters' => ['persona' => $persona],
        ));
    }

    /**
     * @Route(path = "/admin/persona/crear_orden", name = "crear_orden")
     */
    public function crearOrdenAction(Request $request) {

        $em = $this->getDoctrine()->getManager();
        $personas = $this->getDoctrine()->getRepository(Persona::class);
        $id = $request->query->get('id');
        $persona = $personas->find($id);

        $orden = new Orden();
        $orden->setPersona($persona);
        $orden->setFecha(new \DateTime("Now"));
        $form = new OrdenType(OrdenType::class, $orden);
        return $this->redirectToRoute('easyadmin', array(
                    'action' => 'new',
                    'entity' => 'Ordenes',
                    'form' => $form,
                    'orden' => $orden,
        ));
    }

    /**
     * @Route(path = "/admin/persona/estado_de_cuenta", name = "estado_de_cuenta")
     */
    public function estadoDeCuentaAction(Request $request) {

        $em = $this->getDoctrine()->getManager();
        $personas = $em->getRepository(Persona::class);
        $pagosrepo = $em->getRepository(Pago::class);
        $id = $request->query->get('id');
        $persona = $personas->find($id);
        $ordenes = $em->getRepository(Orden::class)->findPendientesByCliente($id);
        $saldo = $total = 0;
        foreach ($ordenes as $orden) {
            $total += $orden->getPrecio();
            $saldo += $orden->getSaldo();
        }

        return $this->render('cliente/estado_de_cuenta.html.twig', array(
                    'cliente' => $persona,
                    'ordenes' => $ordenes,
                    'saldo' => $saldo,
                    'total' => $total,
                        // 'suma'=>$suma,
        ));
    }

    /**
     * @Route(path = "/admin/persona/imprimir_resumen/{id}", name = "imprimir_resumen")
     */
    public function imprimirResumen($id) {

        $em = $this->getDoctrine()->getManager();
        $personas = $em->getRepository(Persona::class);
        $pagosrepo = $em->getRepository(Pago::class);
        $id = $id;
        $persona = $personas->find($id);
        $ordenes = $em->getRepository(Orden::class)->findPendientesByCliente($id);
        $saldo = $total = 0;
        ob_start();
        $df = fopen("php://output", 'w');
        //fputcsv($df, array_keys(reset($array)));
        
        $row=['Numero', 'Fecha',  'Descripcion', 'Precio', 'Pago', 'Saldo'];
        fputcsv($df, $row, ';');
        $total= $saldo=$pagos=0;
        foreach ($ordenes as $orden) {
            $total += $orden->getPrecio();
            $saldo += $orden->getSaldo();
            $pagos +=$orden->getPrecio()-$orden->getSaldo();
            $row = [$orden->getId(), $orden->getFecha()->format('d/m/Y'), $orden->getDescripcion(), $orden->getPrecio(),($orden->getPrecio()-$orden->getSaldo()),$orden->getSaldo()];
            fputcsv($df, $row, ';');
        }

        $row=['Total:', '', '', $total, $pagos, $saldo];
        fputcsv($df, $row,  ';');
        //fclose($df);
        //return ob_get_clean();
       // rewind($df);
        $response = new \Symfony\Component\HttpFoundation\Response(stream_get_contents($df));
        fclose($df);

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="Resumen_'.$persona.'.csv"');

        return $response;
    }

}
