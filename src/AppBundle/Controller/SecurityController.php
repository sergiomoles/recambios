<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Comentarios;
use AppBundle\Entity\Historial;
use AppBundle\Entity\HistorialVehiculo;
use AppBundle\Entity\Objeto;
use AppBundle\Entity\Vehiculo;
use AppBundle\Entity\VehiculoObjeto;
use Proxies\__CG__\AppBundle\Entity\Marca;
use Proxies\__CG__\AppBundle\Entity\Proveedor;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\DateTime;

class SecurityController extends Controller
{

    /**
     * @Route("/", name="recambios_route")
     */
    public function recambiosAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        $em = $this->getDoctrine()->getManager();

        $usuario = $em->find('AppBundle:User', 1);

        return $this->render(
            'security/login.html.twig',
            array(
                // last username entered by the user
                'last_username' => $lastUsername,
                'error' => $error,
                'usuario' => $usuario
            )
        );

    }

    /**
     * @Route("/recambios_check", name="recambios_check")
     * @Security("has_role('ROLE_ADMIN')")
     */

    public function recambiosCheckAction()
    {
        // this controller will not be executed,
        // as the route is handled by the Security system

        $em = $this->getDoctrine()->getManager();

        $usuario = $em->find('AppBundle:User', 1);

        return $this->render(
            'security/portada.html.twig',
            array('usuario' => $usuario)
        );
    }

    /**
     * @Route("/recambios_check/buscador", name="buscador")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method({"GET"})
     */
    public function buscadorAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();


        $usuario = $em->find('AppBundle:User', 1);

        return $this->render(
            'security/buscador.html.twig',
            array('usuario' => $usuario));
    }

    /**
     * @Route("/recambios_check/buscador", name="replenaBuscador")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method({"POST"})
     */
    public function replenaAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $usuario = $em->find('AppBundle:User', 1);

        $request = $this->get('request');
        if ($request->isXmlHttpRequest()) {
            $ajaxData = $request->getContent();

            $ajaxData = "" . $ajaxData . "";

            $ajaxData = explode('/', $ajaxData);
            if($ajaxData[0] == 'bv'){

                # Elimine caracters que no m'interesen.
                $busca = str_replace('[', '', $ajaxData[1]);

                $busca = str_replace('{', '', $busca);

                $busca = str_replace(']', '', $busca);

                $busca = str_replace('}', '', $busca);

                $busca = str_replace('"', '', $busca);

                $busca = explode(",", $busca);

                $matricula = explode(":", $busca[0]);
                $marca = explode(":", $busca[1]);
                $modelo = explode(":", $busca[2]);
                $bastidor = explode(":", $busca[3]);

                $arrayDatos = [$matricula[1],$marca[1],$modelo[1], $bastidor[1]];
                $arrayParametros = [0 => 'matricula', 1 => 'marca', 2 => 'modelo', 3 => 'bastidor'];

                $contador = 0;

                # Consultem per a obtindre el ID de marca i proveidor a traves del seu NOM

                $repoVehicle = $em->getRepository('AppBundle:Vehiculo');

                $queryVehicle = $repoVehicle->createQueryBuilder('v');

                for ($x = 0; $x < sizeof($arrayDatos); $x++) {
                    if ($arrayDatos[$x] != null) {
                        $contador++;

                        if ($contador == 1) {
                            $queryVehicle->where('v.' . $arrayParametros[$x] . ' = ' . "'" . $arrayDatos[$x] . "'");
                        } else {
                            $queryVehicle->andWhere('v.' . $arrayParametros[$x] . ' = ' . "'" . $arrayDatos[$x] . "'");
                        }
                    }
                }
                $aux = $queryVehicle->getQuery();

                $result = $aux->getArrayResult();

            }
            if($ajaxData[0] == 'bp'){
                # Elimine caracters que no m'interesen.
                $busca = str_replace('[', '', $ajaxData[1]);

                $busca = str_replace('{', '', $busca);

                $busca = str_replace(']', '', $busca);

                $busca = str_replace('}', '', $busca);

                $busca = str_replace('"', '', $busca);

                $busca = explode(",", $busca);

                $reffabrica = explode(":", $busca[0]);
                $nombre = explode(":", $busca[1]);
                $refproveedor = explode(":", $busca[2]);
                $ubicacion = explode(":", $busca[3]);
                $cantidad = explode(":", $busca[4]);

                $arrayDatos = [$reffabrica[1],$nombre[1],$refproveedor[1],$ubicacion[1],$cantidad[1]];
                $arrayParametros = [0 => 'reffabrica', 1 => 'nombre', 2 => 'refproveedor', 3 => 'ubicacion', 4 => 'cantidad'];

                $contador = 0;

                # Consultem per a obtindre el ID de marca i proveidor a traves del seu NOM

                $repoProducte = $em->getRepository('AppBundle:Objeto');

                $queryProducte = $repoProducte->createQueryBuilder('p')
                    ->select('objeto','marca','proveedor')
                    ->from('AppBundle:Objeto', 'objeto')
                    ->innerjoin('objeto.marcaid', 'marca')
                    ->innerjoin('objeto.proveedorid', 'proveedor');
                for ($x = 0; $x < sizeof($arrayDatos); $x++) {
                    if ($arrayDatos[$x] != null) {
                        $contador++;

                        if ($contador == 1) {
                            $queryProducte->where('objeto.' . $arrayParametros[$x] . ' = ' . "'" . $arrayDatos[$x] . "'");
                        } else {
                            $queryProducte->andWhere('objeto.' . $arrayParametros[$x] . ' = ' . "'" . $arrayDatos[$x] . "'");
                        }
                    }
                }
                $aux = $queryProducte->getQuery();

                $sql = $aux->getSQL();

                $result = $aux->getArrayResult();



            }
            array_unshift($result, $ajaxData[0]);
            return new JsonResponse($result);
        }
    }

    /**
     * @Route("/recambios_check/stock", name="stock")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method({"GET", "POST"})
     */
    public function stockAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $usuario = $em->find('AppBundle:User', 1);

        $request = $this->get('request');

        if (!$request->isXmlHttpRequest()) {
            return $this->render(
                'security/stock.html.twig',
                array('usuario' => $usuario));
        }


        if ($request->isXmlHttpRequest()) {

            # La seguent linea rep les dades del post JSON
            $ajaxdata = $request->getContent();

            # En el seguent if es comproba si les dades rebudes per JSON contenen una coma,
            # en cas de no contindre cap coma vol dir que es un codi i que pertany a
            # la primera cridada AJAX [Replenar formulari].
            if (!strpos($ajaxdata, ',')) {

                $ajaxstring = "'" . $ajaxdata . "'";

                # Esta consulta retorna un array amb les dades del objecte
                $repository = $em->getRepository('AppBundle:Objeto');

                $query = $repository->createQueryBuilder('p')
                    ->select('objeto','marca','proveedor')
                    ->from('AppBundle:Objeto', 'objeto')
                    ->innerjoin('objeto.marcaid', 'marca')
                    ->innerjoin('objeto.proveedorid', 'proveedor')
                    ->where('objeto.reffabrica = ' . $ajaxstring)
                    ->getQuery();

                $resultado = $query->getArrayResult();

                # El JsonResponse envia a la plantilla twig una variable que es diu resp
                return new JsonResponse($resultado);
            }
            # En el seguent if es comproba si les dades rebudes per JSON contenen una coma,
            # en cas de contindre la coma vol dir que es un array amb totes les dades del formulari
            # i que pertany a la segona cridada AJAX [Actualitzar Base de dades]
            if (strpos($ajaxdata, ',')) {

                $updatestring = '' . $ajaxdata . '';

                # Sustituisc al string els : per = per a tindre les condicions per al update ja montades.
                $updatestring = str_replace(':', '=', $updatestring);

                # Elimine caracters que no m'interesen.
                $updatestring = str_replace('[', '', $updatestring);

                $updatestring = str_replace('{', '', $updatestring);

                $updatestring = str_replace(']', '', $updatestring);

                $updatestring = str_replace('}', '', $updatestring);

                $updatestring = str_replace('"', '', $updatestring);

                # Separe el string en un array per a poder montar el update mes comodament.
                $condiciones = explode(",", $updatestring);

                $fab = explode("=", $condiciones[0]);
                $nombre = explode("=", $condiciones[1]);
                $prov = explode("=", $condiciones[2]);
                $desc = explode("=", $condiciones[3]);
                $prent = explode("=", $condiciones[4]);
                $prsal = explode("=", $condiciones[5]);
                $ubi = explode("=", $condiciones[6]);
                $marca = explode("=", $condiciones[7]);
                $provnom = explode("=", $condiciones[8]);


                # Consultem per a obtindre el ID de marca i proveidor a traves del seu NOM
                $repomarca = $em->getRepository('AppBundle:Marca');

                $querymarca = $repomarca->createQueryBuilder('m');
                $querymarca->where('m.nombre=' . "'" . $marca[1] . "'");
                $resultmarca = $querymarca->getQuery()->getArrayResult();

                $repoprov = $em->getRepository('AppBundle:Proveedor');

                $queryprov = $repoprov->createQueryBuilder('p');
                $queryprov->where('p.nombre=' . "'" . $provnom[1] . "'");
                $resultprov = $queryprov->getQuery()->getArrayResult();


                #Montem consulta
                $factual = date("Y-m-d");

                $objeto = $em->getRepository('AppBundle:Objeto');

                $querybuilder = $objeto->createQueryBuilder('b');
                $querybuilder->update();

                $querybuilder->set('b.' . $nombre[0] . '', "'" . $nombre[1] . "'");
                $querybuilder->set('b.' . $prov[0] . '', "'" . $prov[1] . "'");
                $querybuilder->set('b.' . $desc[0] . '', "'" . $desc[1] . "'");
                $querybuilder->set('b.' . $prent[0] . '', "'" . $prent[1] . "'");
                $querybuilder->set('b.' . $prsal[0] . '', "'" . $prsal[1] . "'");
                $querybuilder->set('b.' . $ubi[0] . '', "'" . $ubi[1] . "'");
                $querybuilder->set('b.fechamodificacion', "'" . $factual . "'");
                $querybuilder->set('b.marcaid', $resultmarca[0]['id']);
                $querybuilder->set('b.proveedorid', $resultprov[0]['id']);

                $querybuilder->where("b.reffabrica =" . "'" . $fab[1] . "'");

                # Executem consulta
                $qbs = $querybuilder->getQuery();

                $respuesta = $qbs->getResult();


                $texto = '';
                if ($respuesta != '') {
                    $texto = 'Actualitzat correctament.';

                    # Insertem en Historial la ¡Modificacio! realitzada

                    $historial = new Historial();

                    $historial->setNombre("" . $nombre[1] . "");
                    $historial->setFecha(new \DateTime());
                    $historial->setHora(new \DateTime());
                    $movimientoid = $em->getReference('\AppBundle\Entity\TipoMovimiento', 1);
                    $historial->setMovimientoid($movimientoid);

                    $em2 = $this->getDoctrine()->getEntityManager();

                    $em2->persist($historial);
                    $em2->flush();
                } else {
                    if ($respuesta == '') {
                        $nuevo = new Objeto();


                        $nuevo->setNombre("" . $nombre[1] . "");
                        $nuevo->setRefproveedor("" . $prov[1] . "");
                        $nuevo->setReffabrica("" . $fab[1] . "");
                        $nuevo->setDescripcion("" . $desc[1] . "");
                        $nuevo->setPrecioentrada((int)$prent[1]);
                        $nuevo->setPreciosalida((int)$prsal[1]);
                        $nuevo->setUbicacion("" . $ubi[1] . "");
                        $nuevo->setFechaalta(new \DateTime());
                        $nuevo->setCantidad(1);
                        $nuevo->setFechamodificacion(new \DateTime());

                        # Proveedor i marca se obtenen en la part anterior -> Guardar canvi
                        $provid = $em->getReference('\AppBundle\Entity\Proveedor', $resultprov[0]['id']);
                        $nuevo->setProveedorid($provid);

                        $marcaid =  $em->getReference('\AppBundle\Entity\Marca', $resultmarca[0]['id']);
                        $nuevo->setMarcaid($marcaid);

                        $nuevo->setFuerastock(0);

                        $em2 = $this->getDoctrine()->getEntityManager();

                        $em2->persist($nuevo);
                        $em2->flush();


                        $texto = 'Nou producte afegit al estoc.';


                        # Insertem en Historial la ¡Insercio! realitzada

                        $historial = new Historial();

                        $historial->setNombre("" . $nombre[1] . "");
                        $historial->setFecha(new \DateTime());
                        $historial->setHora(new \DateTime());

                        $movimientoid = $em->getReference('\AppBundle\Entity\TipoMovimiento', 4);
                        $historial->setMovimientoid($movimientoid);

                        $em2 = $this->getDoctrine()->getEntityManager();

                        $em2->persist($historial);
                        $em2->flush();
                    }
                }

                #Retornem confirmacio
                return new JsonResponse($texto);
            }
        }

    }


    /**
     * @Route("/recambios_check/stock", name="quantitats")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method({"PUT"})
     */
    public function quantitatsAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        $request = $this->get('request');

        if ($request->isXmlHttpRequest()) {

            $incrementa = $request->getContent();

            $incrementa = str_replace('[', '', $incrementa);

            $incrementa = str_replace('{', '', $incrementa);

            $incrementa = str_replace(']', '', $incrementa);

            $incrementa = str_replace('}', '', $incrementa);

            $incrementa = str_replace('"', '', $incrementa);

            $datos = explode(",", $incrementa);



            if($datos[0] == 'pujar') {

                # Obte la cantitat total del producte per a saber si ha de traurel de fora d'estoc.
                $objeto2 = $em->getRepository('AppBundle:Objeto');

                $qb2 = $objeto2->createQueryBuilder('h');
                $qb2->where('h.reffabrica=' . "'" . $datos[1] . "'");


                $producto = $qb2->getQuery()->getArrayResult();

                if ($producto[0]['cantidad'] == 0){
                    $objeto = $em->getRepository('AppBundle:Objeto');

                    $qb = $objeto->createQueryBuilder('j');
                    $qb->update();
                    $qb->set('j.fuerastock', '0');
                    $qb->where('j.reffabrica=' . "'" . $datos[1] . "'");

                    $obj = $qb->getQuery()->getResult();

                }

                # Incrementa la cantitat del producte
                $objeto = $em->getRepository('AppBundle:Objeto');

                $qb = $objeto->createQueryBuilder('i');
                $qb->update();
                $qb->set('i.cantidad', 'i.cantidad + 1');
                $qb->where('i.reffabrica=' . "'" . $datos[1] . "'");

                $obj = $qb->getQuery()->getResult();

                # Obte la cantitat total del producte per a informar
                $objeto2 = $em->getRepository('AppBundle:Objeto');

                $qb2 = $objeto2->createQueryBuilder('h');
                $qb2->where('h.reffabrica=' . "'" . $datos[1] . "'");


                $producto = $qb2->getQuery()->getArrayResult();

                $texto = '';

                if ($obj != NULL) {
                    # Insertem en Historial el ¡Increment! realitzat

                    $historial = new Historial();

                    $historial->setNombre("'" . $producto[0]['nombre'] . "'");
                    $historial->setFecha(new \DateTime());
                    $historial->setHora(new \DateTime());
                    $movimientoid = $em->getReference('\AppBundle\Entity\TipoMovimiento', 2);
                    $historial->setMovimientoid($movimientoid);

                    $em2 = $this->getDoctrine()->getEntityManager();

                    $em2->persist($historial);
                    $em2->flush();

                    $texto = "Cantitat augmentada. Total:  " . $producto[0]['cantidad'] . "";
                    return new JsonResponse($texto);
                } else {


                    $texto = 'Error al incrementar la cantitat del producte.';
                    return new JsonResponse($texto);
                }
            }
            if($datos[0] == 'baixar'){

                #Primer comprobem la cantitat
                $objeto3 = $em->getRepository('AppBundle:Objeto');

                $qb3 = $objeto3->createQueryBuilder('h');
                $qb3->where('h.reffabrica=' . "'" . $datos[1] . "'");

                $producto = $qb3->getQuery()->getArrayResult();


                if($producto[0]['cantidad']==1){
                    #Reduim la cantitat i fiquem en fora d'estoc

                    $objeto = $em->getRepository('AppBundle:Objeto');

                    $qb = $objeto->createQueryBuilder('j');
                    $qb->update();
                    $qb->set('j.cantidad', 'j.cantidad-1');
                    $qb->set('j.fuerastock', '1');
                    $qb->where('j.reffabrica=' . "'" . $datos[1] . "'");

                    $obj = $qb->getQuery()->getResult();

                    # Insertem en Historial el ¡Decrement! realitzat

                    $historial = new Historial();

                    $historial->setNombre("'" . $producto[0]['nombre'] . "'");
                    $historial->setFecha(new \DateTime());
                    $historial->setHora(new \DateTime());
                    $movimientoid = $em->getReference('\AppBundle\Entity\TipoMovimiento', 3);
                    $historial->setMovimientoid($movimientoid);

                    $em2 = $this->getDoctrine()->getEntityManager();

                    $em2->persist($historial);
                    $em2->flush();

                    # Enviem resposta
                    $texto = 'Aquest producte ja no està en estoc.';
                    return new JsonResponse($texto);

                }
                else{

                    #Reduim la cantitat

                    $objeto = $em->getRepository('AppBundle:Objeto');

                    $qb = $objeto->createQueryBuilder('k');
                    $qb->update();
                    $qb->set('k.cantidad', 'k.cantidad-1');
                    $qb->where('k.reffabrica=' . "'" . $datos[1] . "'");

                    $obj = $qb->getQuery()->getResult();

                    #Comprobem la cantitat total
                    $objeto3 = $em->getRepository('AppBundle:Objeto');

                    $qb3 = $objeto3->createQueryBuilder('h');
                    $qb3->where('h.reffabrica=' . "'" . $datos[1] . "'");

                    $producto = $qb3->getQuery()->getArrayResult();

                    if ($obj != NULL) {
                        # Insertem en Historial el ¡Decrement! realitzat

                        $historial = new Historial();

                        $historial->setNombre("'" . $producto[0]['nombre'] . "'");
                        $historial->setFecha(new \DateTime());
                        $historial->setHora(new \DateTime());
                        $movimientoid = $em->getReference('\AppBundle\Entity\TipoMovimiento', 3);
                        $historial->setMovimientoid($movimientoid);

                        $em2 = $this->getDoctrine()->getEntityManager();

                        $em2->persist($historial);
                        $em2->flush();

                        # Enviem resposta
                        $texto = "Cantitat disminuida. Total: " . $producto[0]['cantidad'] . "";
                        return new JsonResponse($texto);
                    }
                    else{
                        $texto = 'Error al incrementar la cantitat del producte.';
                        return new JsonResponse($texto);
                    }


                }

            }

        }

    }

    /**
     * @Route("/recambios_check/vehicle", name="vehicle")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method({"POST", "GET"})
     */
    public function vehicleAction(Request $request){
        $em = $this->getDoctrine()->getManager();

        $usuario = $em->find('AppBundle:User', 1);

        if ($request->isXmlHttpRequest()) {

            # La seguent linea rep les dades del post JSON
            $ajaxdata = $request->getContent();

            # En el seguent if es comproba si les dades rebudes per JSON contenen una coma,
            # en cas de no contindre cap coma vol dir que es un codi i que pertany a
            # la primera cridada AJAX [Replenar formulari].
            if (!strpos($ajaxdata, ',')) {

                $ajaxstring = "'" . $ajaxdata . "'";

               # Array amb les dades del vehicle.
                $repoVehicle = $em->getRepository('AppBundle:Vehiculo');

                $query = $repoVehicle->createQueryBuilder('v')
                    ->where('v.matricula = ' . $ajaxstring)
                    ->getQuery();

                $dadesVehicle = $query->getArrayResult();

                # Array amb les dades del historial.
                $repoHist = $em->getRepository('AppBundle:HistorialVehiculo');

                $qbHistorial = $repoHist->createQueryBuilder('h')
                    ->select('historial', 'movimiento', 'objeto')
                    ->from('AppBundle:HistorialVehiculo', 'historial')
                    ->innerjoin('historial.movimientoid', 'movimiento')
                    ->innerjoin('historial.objetoId', 'objeto')
                    ->where('historial.vehiculoId =' . $dadesVehicle[0]['id'])
                    ->add('orderBy','historial.fecha DESC, historial.hora DESC')
                    ->getQuery();
                $dadesHistorial = $qbHistorial->getArrayResult();

                # Array amb els productes actuals del vehicle

                $repoObjVehicle = $em->getRepository('AppBundle:VehiculoObjeto');

                $qbObjV = $repoObjVehicle->createQueryBuilder('vo')
                    ->select('objeto', 'vehiculo')
                    ->from('AppBundle:VehiculoObjeto', 'vehiculo')
                    ->innerjoin('vehiculo.objetoId', 'objeto')
                    ->where('vehiculo.vehiculoId =' . $dadesVehicle[0]['id'])
                    ->orderBy("vehiculo.fechaEntrada", 'DESC')
                    ->getQuery();
                $dadesObjectes = $qbObjV->getArrayResult();

                # Array amb les dades dels comentaris.
                $repoComent = $em->getRepository('AppBundle:Comentarios');

                $qbComent = $repoComent->createQueryBuilder('c')
                    ->where('c.vehiculoId =' . $dadesVehicle[0]['id'])
                    ->orderBy("c.fecha", 'DESC')
                    ->orderBy("c.hora", 'DESC')
                    ->getQuery();
                $dadesComent = $qbComent->getArrayResult();

                $dadesFinal = [
                    'vehicle' => $dadesVehicle,
                    'historial' => $dadesHistorial,
                    'objecte' => $dadesObjectes,
                    'comentaris' => $dadesComent
                ];
                if($dadesVehicle == ''){
                    $dadesFinal = '';
                }

                # El JsonResponse envia a la plantilla twig una variable que es diu resp
                return new JsonResponse($dadesFinal);
            }
            # En el seguent if es comproba si les dades rebudes per JSON contenen una coma,
            # en cas de contindre la coma vol dir que es un array amb totes les dades del formulari
            # i que pertany a la segona cridada AJAX [Actualitzar Base de dades]
            if(strpos($ajaxdata, ',')){

                $updatestring = '' . $ajaxdata . '';

                # Sustituisc al string els : per = per a tindre les condicions per al update ja montades.
                $updatestring = str_replace(':', '=', $updatestring);

                # Elimine caracters que no m'interesen.
                $updatestring = str_replace('[', '', $updatestring);

                $updatestring = str_replace('{', '', $updatestring);

                $updatestring = str_replace(']', '', $updatestring);

                $updatestring = str_replace('}', '', $updatestring);

                $updatestring = str_replace('"', '', $updatestring);

                # Separe el string en un array per a poder montar el update mes comodament.
                $condicions = explode(",", $updatestring);

                $matricula = explode('=', $condicions[0]);
                $marca = explode('=',$condicions[1]);
                $modelo = explode('=',$condicions[2]);
                $bastidor = explode('=',$condicions[3]);

                #Montem consulta
                $factual = date("Y-m-d");

                $vehiculo = $em->getRepository('AppBundle:Vehiculo');

                $querybuilder = $vehiculo->createQueryBuilder('v2');
                $querybuilder->update();

                $querybuilder->set('v2.' . $marca[0] . '', "'" . $marca[1] . "'");
                $querybuilder->set('v2.' . $modelo[0] . '', "'" . $modelo[1] . "'");
                $querybuilder->set('v2.fechamodificacion', "'" . $factual . "'");
                $querybuilder->set('v2.' . $bastidor[0] . '', "'" . $bastidor[1] . "'");

                $querybuilder->where("v2.matricula =" . "'" . $matricula[1] . "'");

                # Executem consulta
                $qbv = $querybuilder->getQuery();

                $respuesta = $qbv->getResult();

                $texto = '';
                if ($respuesta != '') {
                    $texto = 'Actualitzat correctament.';

                    # Insertem en Historial la ¡Modificacio! realitzada

                    $historial = new HistorialVehiculo();

                    $historial->setFecha(new \DateTime());
                    $historial->setHora(new \DateTime());

                    # Obtenim el id del vehicle per mig de la matricula
                    # Consulta per a traure el id.
                    $qbIdVehicle = $vehiculo->createQueryBuilder('v3')
                        ->select('v3.id')
                        ->where('v3.matricula =' . "'" . $matricula[1] . "'")
                        ->getQuery();
                    $respVehicle = $qbIdVehicle->getResult();

                    $vehicleId = $em->getReference('\AppBundle\Entity\Vehiculo', $respVehicle[0]);

                    $historial->setVehiculoid($vehicleId);


                    $movimientoId = $em->getReference('\AppBundle\Entity\TipoMovimiento', 1);
                    $historial->setMovimientoid($movimientoId);

                    $em2 = $this->getDoctrine()->getEntityManager();

                    $em2->persist($historial);
                    $em2->flush();



                } else {
                    if ($respuesta == '') {

                        $nuevo = new Vehiculo();


                        $nuevo->setMatricula("" . $matricula[1] . "");
                        $nuevo->setMarca("" . $marca[1] . "");
                        $nuevo->setModelo("" . $modelo[1] . "");
                        $nuevo->setFechaalta(new \DateTime());
                        $nuevo->setFechamodificacion(new \DateTime());
                        $nuevo->setBastidor("" . $bastidor[1] . "");

                        $em2 = $this->getDoctrine()->getEntityManager();

                        $em2->persist($nuevo);
                        $em2->flush();


                        $texto = 'Nou vehicle afegit.';


                        # Insertem en Historial la ¡Insercio! realitzada

                        $historial = new HistorialVehiculo();

                        $historial->setFecha(new \DateTime());
                        $historial->setHora(new \DateTime());

                        # Obtenim el id del vehicle per mig de la matricula
                        # Consulta per a traure el id.
                        $qbIdVehicle = $vehiculo->createQueryBuilder('v3')
                            ->select('v3.id')
                            ->where('v3.matricula =' . "'" . $matricula[1] . "'")
                            ->getQuery();
                        $respVehicle = $qbIdVehicle->getResult();

                        $vehicleId = $em->getReference('\AppBundle\Entity\Vehiculo', $respVehicle[0]);

                        $historial->setVehiculoid($vehicleId);


                        $movimientoId = $em->getReference('\AppBundle\Entity\TipoMovimiento', 4);
                        $historial->setMovimientoid($movimientoId);

                        $em2 = $this->getDoctrine()->getEntityManager();

                        $em2->persist($historial);
                        $em2->flush();

                    }
                }

                #Retornem confirmacio
                return new JsonResponse($texto);
            }
        }
        if (!$request->isXmlHttpRequest()) {
            return $this->render(
                'security/vehicle.html.twig',
                array('usuario' => $usuario));
        }
    }

    /**
     * @Route("/recambios_check/vehicle", name="asigna")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method({"PUT"})
     */
    public function asignaAction(Request $request){

        $texto = "";

        $em = $this->getDoctrine()->getManager();

        $request = $this->get('request');

        if ($request->isXmlHttpRequest()) {

            $aux = $request->getContent();

            if (strpos($aux, 'noucomentari:')) {
                $texto = "";

                $em = $this->getDoctrine()->getManager();

                $request = $this->get('request');

                if ($request->isXmlHttpRequest()) {
                    $comentari = $request->getContent();

                    $comentari = str_replace('noucomentari:', '', $comentari);
                    $comentari = str_replace('"', '', $comentari);

                    $datos = explode(",", $comentari);

                    $vehicle = $em->getRepository('AppBundle:Vehiculo');

                    $qb = $vehicle->createQueryBuilder('v');
                    $qb->where('v.matricula=' . "'" . $datos[1] . "'");
                    $respVehicle = $qb->getQuery()->getArrayResult();



                    $nouComentari = new Comentarios();


                    $vehicleId = $em->getReference('\AppBundle\Entity\Vehiculo', $respVehicle[0]['id']);
                    $nouComentari->setVehiculoId($vehicleId);

                    $nouComentari->setComentario($datos[0]);

                    $nouComentari->setFecha(new \DateTime());

                    $nouComentari->setHora(new \DateTime());

                    $em2 = $this->getDoctrine()->getManager();
                    $em2->persist($nouComentari);
                    $em2->flush();

                    $texto = "Nou comentari afegit.";
                }

                return new JsonResponse($texto);

            }

            if (!strpos($aux, 'noucomentari:')) {

                $incrementa = $request->getContent();

                $incrementa = str_replace('[', '', $incrementa);

                $incrementa = str_replace('{', '', $incrementa);

                $incrementa = str_replace(']', '', $incrementa);

                $incrementa = str_replace('}', '', $incrementa);

                $incrementa = str_replace('"', '', $incrementa);

                $datos = explode(",", $incrementa);


                if ($datos[0] == 'incloure') {

                    # Obte la cantitat total del producte per a saber si ha de traurel de fora d'estoc.
                    $objeto2 = $em->getRepository('AppBundle:Objeto');

                    $qb2 = $objeto2->createQueryBuilder('h');
                    $qb2->where('h.reffabrica=' . "'" . $datos[1] . "'");


                    $producto = $qb2->getQuery()->getArrayResult();

                    # Si el producte cantitat = 0 o per error es menor que 0 no fa cap operacio
                    if ($producto[0]['cantidad'] == 0 || $producto[0]['cantidad'] < 0) {
                        $texto = "No es pot afegir el producte ja que esta fora d'estoc.";
                    }

                    # Si la cantitat = 1 insertem i fiquem fora de estoc el producte
                    if ($producto[0]['cantidad'] == 1) {
                        #Reduim la cantitat i fiquem en fora d'estoc

                        $objeto = $em->getRepository('AppBundle:Objeto');

                        $qb = $objeto->createQueryBuilder('j');
                        $qb->update();
                        $qb->set('j.cantidad', 'j.cantidad-1');
                        $qb->set('j.fuerastock', '1');
                        $qb->where('j.reffabrica=' . "'" . $datos[1] . "'");

                        $obj = $qb->getQuery()->getResult();

                        # Insertem en Historial el ¡Decrement! realitzat

                        $historial = new Historial();

                        $historial->setNombre("'" . $producto[0]['nombre'] . "'");
                        $historial->setFecha(new \DateTime());
                        $historial->setHora(new \DateTime());
                        $movimientoid = $em->getReference('\AppBundle\Entity\TipoMovimiento', 3);
                        $historial->setMovimientoid($movimientoid);

                        $em2 = $this->getDoctrine()->getEntityManager();

                        $em2->persist($historial);
                        $em2->flush();

                        $texto = "S'ha inclos el producte al vehicle.";

                    }

                    # Si hi ha suficient estoc, asigna el producte, inserta en el historial i modifica les cantitats
                    if ($producto[0]['cantidad'] > 1) {

                        #Reduim la cantitat

                        $objeto = $em->getRepository('AppBundle:Objeto');

                        $qb = $objeto->createQueryBuilder('k');
                        $qb->update();
                        $qb->set('k.cantidad', 'k.cantidad-1');
                        $qb->where('k.reffabrica=' . "'" . $datos[1] . "'");

                        $obj = $qb->getQuery()->getResult();

                        # Insertem en Historial el ¡Decrement! realitzat

                        $historial = new Historial();

                        $historial->setNombre("'" . $producto[0]['nombre'] . "'");
                        $historial->setFecha(new \DateTime());
                        $historial->setHora(new \DateTime());
                        $movimientoid = $em->getReference('\AppBundle\Entity\TipoMovimiento', 3);
                        $historial->setMovimientoid($movimientoid);

                        $em2 = $this->getDoctrine()->getEntityManager();

                        $em2->persist($historial);
                        $em2->flush();
                    }

                    # Obtenim el ID del vehicle

                    $vehicle = $em->getRepository('AppBundle:Vehiculo');

                    $qb4 = $vehicle->createQueryBuilder('v');
                    $qb4->where('v.matricula=' . "'" . $datos[2] . "'");

                    $respVehicle = $qb4->getQuery()->getArrayResult();

                    # Insertem en vehicleObjecte

                    $vehicleObjecte = new VehiculoObjeto();

                    $objId = $em->getReference('\AppBundle\Entity\Objeto', $producto[0]['id']);
                    $vehicleObjecte->setObjetoId($objId);

                    $vehId = $em->getReference('\AppBundle\Entity\Vehiculo', $respVehicle[0]['id']);
                    $vehicleObjecte->setVehiculoId($vehId);

                    $vehicleObjecte->setFechaEntrada(new \DateTime());

                    $em4 = $this->getDoctrine()->getEntityManager();

                    $em4->persist($vehicleObjecte);
                    $em4->flush();

                    # Insertem en el historial de vehicle

                    $historial = new HistorialVehiculo();

                    $historial->setFecha(new \DateTime());
                    $historial->setHora(new \DateTime());

                    $vehicleId = $em->getReference('\AppBundle\Entity\Vehiculo', $respVehicle[0]['id']);
                    $historial->setVehiculoid($vehicleId);

                    $objetoId = $em->getReference('\AppBundle\Entity\Objeto', $producto[0]['id']);
                    $historial->setObjetoId($objetoId);


                    $movimientoId = $em->getReference('\AppBundle\Entity\TipoMovimiento', 2);
                    $historial->setMovimientoid($movimientoId);

                    $em2 = $this->getDoctrine()->getEntityManager();

                    $em2->persist($historial);
                    $em2->flush();

                    $texto = "S'ha inclos el producte al vehicle.";

                }

                if ($datos[0] == 'retirar') {

                    # Obte la cantitat total del producte per a saber si ha de ficar-lo en estoc.
                    $objeto2 = $em->getRepository('AppBundle:Objeto');

                    $qb2 = $objeto2->createQueryBuilder('h');
                    $qb2->where('h.reffabrica=' . "'" . $datos[1] . "'");


                    $producto = $qb2->getQuery()->getArrayResult();

                    # Si el producte esta fora d'estoc he de ficar-lo en estoc i incrementar la seua cantitat.
                    if ($producto[0]['cantidad'] == 0) {
                        $objeto = $em->getRepository('AppBundle:Objeto');

                        $qb = $objeto->createQueryBuilder('j');
                        $qb->update();
                        $qb->set('j.fuerastock', '0');
                        $qb->where('j.reffabrica=' . "'" . $datos[1] . "'");

                        $obj = $qb->getQuery()->getResult();
                    }

                    $objeto = $em->getRepository('AppBundle:Objeto');

                    $qb = $objeto->createQueryBuilder('j');
                    $qb->update();
                    $qb->set('j.cantidad', 'j.cantidad+1');
                    $qb->where('j.reffabrica=' . "'" . $datos[1] . "'");

                    $obj = $qb->getQuery()->getResult();

                    #Insertem en historial

                    $historial = new Historial();

                    $historial->setNombre("'" . $producto[0]['nombre'] . "'");
                    $historial->setFecha(new \DateTime());
                    $historial->setHora(new \DateTime());
                    $movimientoid = $em->getReference('\AppBundle\Entity\TipoMovimiento', 2);
                    $historial->setMovimientoid($movimientoid);

                    $em2 = $this->getDoctrine()->getEntityManager();

                    $em2->persist($historial);
                    $em2->flush();


                    # Obtenim el ID del vehicle

                    $vehicle = $em->getRepository('AppBundle:Vehiculo');

                    $qb4 = $vehicle->createQueryBuilder('v');
                    $qb4->where('v.matricula=' . "'" . $datos[2] . "'");

                    $respVehicle = $qb4->getQuery()->getArrayResult();

                    # Insertem en el historial de vehicle

                    $historialv = new HistorialVehiculo();

                    $historialv->setFecha(new \DateTime());
                    $historialv->setHora(new \DateTime());

                    $vehicleId = $em->getReference('\AppBundle\Entity\Vehiculo', $respVehicle[0]['id']);
                    $historialv->setVehiculoid($vehicleId);

                    $objetoId = $em->getReference('\AppBundle\Entity\Objeto', $producto[0]['id']);
                    $historialv->setObjetoId($objetoId);

                    $movimientoId = $em->getReference('\AppBundle\Entity\TipoMovimiento', 3);
                    $historialv->setMovimientoid($movimientoId);

                    $em2 = $this->getDoctrine()->getEntityManager();

                    $em2->persist($historialv);
                    $em2->flush();


                    # Eliminem la linea de la taula vehicleObject

                    $repoAux = $em->getRepository('AppBundle:VehiculoObjeto');

                    $queryAux = $repoAux->createQueryBuilder('q')
                        ->select('objeto', 'vehiculo')
                        ->from('AppBundle:VehiculoObjeto', 'vehiculo')
                        ->innerjoin('vehiculo.objetoId','objeto')
                        ->where('vehiculo.objetoId = ' . $producto[0]['id'] . "")
                        ->andwhere('vehiculo.vehiculoId = ' . $respVehicle[0]['id'] . "")
                        ->getQuery();

                    $resultAux = $queryAux->getArrayResult();
                    $sql = $queryAux->getSQL();

                    $borrar = $repoAux->find($resultAux[0]['id']);

                    $em->remove($borrar);
                    $em->flush();

                    $texto = "S'ha retirat el producte del vehicle.";


                }
            }
        }

        return new JsonResponse($texto);
    }

     /**
     * @Route("/recambios_check/historial", name="historial")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method({"POST", "PUT", "GET"})
     */
    public function historialAction(Request $request){
        $em = $this->getDoctrine()->getManager();

        $usuario = $em->find('AppBundle:User', 1);


        $request = $this->get('request');

        if (!$request->isXmlHttpRequest()) {
            return $this->render(
                'security/historial.html.twig',
                array('usuario' => $usuario));
        }

        if ($request->isXmlHttpRequest()) {
            $repoHistorial = $em->getRepository('AppBundle:Historial');

            $queryHistorial = $repoHistorial->createQueryBuilder('h')
                ->select('historial', 'tipomovimiento')
                ->from('AppBundle:Historial', 'historial')
                ->innerjoin('historial.movimientoid', 'tipomovimiento')
                ->add('orderBy','historial.fecha DESC, historial.hora DESC')
                ->getQuery();

            $resultHist = $queryHistorial->getArrayResult();
            return new JsonResponse($resultHist);
        }
    }

    /**
     * @Route("/recambios_check/proveedor", name="proveedor")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method({"POST", "PUT", "GET"})
     */
    public function proveedorAction(Request $request){

        $em = $this->getDoctrine()->getManager();

        $usuario = $em->find('AppBundle:User', 1);

        $request = $this->get('request');

        $texto = "";

        if (!$request->isXmlHttpRequest()) {


            $repoMarca = $em->getRepository('AppBundle:Marca');
            $queryMarca = $repoMarca->createQueryBuilder('m')
                ->orderby('m.nombre', 'DESC')
                ->getQuery();
            $resultMarca = $queryMarca->getResult();

            $repoProv = $em->getRepository('AppBundle:Proveedor');
            $queryProv = $repoProv->createQueryBuilder('p')
                ->orderby('p.nombre', 'DESC')
                ->getQuery();
            $resultProv = $queryProv->getResult();


            #Buscar els proveidors i les marques i enviarlos a la plantilla per a que mostre tots els valors


            return $this->render(
                'security/proveedor.html.twig',
                array('usuario' => $usuario, 'marca' => $resultMarca, 'proveidor' => $resultProv));
        }
        if($request->isXmlHttpRequest()){
            $ajaxData = $request->getContent();

            $ajaxData = "" . $ajaxData . "";

            $ajaxData = explode('/', $ajaxData);
            if($ajaxData[0] == 'marca'){
                $busca = str_replace('[', '', $ajaxData[1]);

                $busca = str_replace('{', '', $busca);

                $busca = str_replace(']', '', $busca);

                $busca = str_replace('}', '', $busca);

                $busca = str_replace('"', '', $busca);

                $busca = explode(":", $busca);


                $marca = new Marca();

                $marca->setNombre($busca[1]);

                $em2 = $this->getDoctrine()->getManager();

                $em2->persist($marca);
                $em2->flush();

                $texto = "S'ha introduit una nova marca.";
            }
            if($ajaxData[0] == 'proveedor'){
                $busca = str_replace('[', '', $ajaxData[1]);

                $busca = str_replace('{', '', $busca);

                $busca = str_replace(']', '', $busca);

                $busca = str_replace('}', '', $busca);

                $busca = str_replace('"', '', $busca);

                $busca = explode(",", $busca);


                $nom = explode(":", $busca[0]);

                $numproveedor = explode(":", $busca[1]);

                $correo = explode(":", $busca[2]);

                $telefono = explode(":", $busca[3]);

                $proveedor = new Proveedor();

                $proveedor->setNombre($nom[1]);

                $proveedor->setNumproveedor($numproveedor[1]);

                $proveedor->setCorreo($correo[1]);

                $proveedor->setTelefono($telefono[1]);

                $em2 = $this->getDoctrine()->getManager();

                $em2->persist($proveedor);
                $em2->flush();

                $texto = "S'ha introduit un nou proveidor.";
            }

            return new JsonResponse($texto);
        }
    }

}