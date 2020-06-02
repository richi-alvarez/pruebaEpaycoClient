<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints\Email;

class WhalletController extends AbstractController
{
    public $url;

    public function __construct(){
        $this->url = 'http://localhost/prueba_epayco/php/pruebaEpayco/public';
    }
    private function resjson($data){
        //Serializar datos con servicio serializer
        $json = $this->get('serializer')->serialize($data, 'json');
        //response con httpfoundation
        $response = new Response();
        //Asignar contenido a la respuesta
        $response->setContent($json);
        //Indicar formato de respuesta
        $response->headers->set('Content-Type', 'application/json');
        //Devolver la respuesta
        return $response;
    }
    public function index()
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/WhalletController.php',
        ]);
    }
    public function recargar(Request $request){
        //recojer los datos por post
        $json = $request->get('json', null);
        //decodificar el json
        $params_array  = json_decode($json, true);
        $token = $request->headers->get('Authorization', null);
        $array = explode(' ', $token);
        $arraymarge = array_merge($params_array, $array);
        //comprobar y valdiar datos
        if($token != null){
        $json=  json_encode($arraymarge);
        $curl = curl_init();
            curl_setopt_array($curl, array(
          CURLOPT_URL => $this->url."/recargar",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS =>$json,
          CURLOPT_HTTPHEADER => array(
            "Content-Type: application/json",
            "Accept: application/json"
          ),
        ));
        $result = curl_exec($curl);
         curl_close($curl);
         $data = json_decode($result, true);
        
        }else{
            $data = [
                'status' => 'error',
                'code' => 400,
                'message' => 'no se enviaron datos o datos incorrectos'
            ];
        }
        return $this->resjson($data);
    }

    public function pagar(Request $request){
        //recojer los datos por post
        $json = $request->get('json', null);
        //decodificar el json
        $params_array  = json_decode($json, true);
        $token = $request->headers->get('Authorization', null);
        $array = explode(' ', $token);
        $arraymarge = array_merge($params_array, $array);
        //comprobar y valdiar datos
        if($token != null){
        $json=  json_encode($arraymarge);
        $curl = curl_init();
            curl_setopt_array($curl, array(
          CURLOPT_URL => $this->url."/pagar",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS =>$json,
          CURLOPT_HTTPHEADER => array(
            "Content-Type: application/json",
            "Accept: application/json"
          ),
        ));
        $result = curl_exec($curl);
         curl_close($curl);
         $data = json_decode($result, true);
        }else{
            $data = [
                'status' => 'error',
                'code' => 400,
                'message' => 'no se enviaron datos o datos incorrectos'
            ];
        }
        return $this->resjson($data);
    }

    public function confirmar(Request $request){
        //recojer los datos por post
        $json = $request->get('json', null);
        //decodificar el json
        $params_array  = json_decode($json, true);
        $token = $request->headers->get('Authorization', null);
        $array = explode(' ', $token);
        $sessionId = $request->headers->get('sessionId', null);
        $array2 = explode(' ', $sessionId);
        $arraymarge = array_merge($params_array, $array, $array2);
        //comprobar y valdiar datos
        if($token != null){
        $json=  json_encode($arraymarge);
        $curl = curl_init();
            curl_setopt_array($curl, array(
          CURLOPT_URL =>$this->url. "/confirmar",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS =>$json,
          CURLOPT_HTTPHEADER => array(
            "Content-Type: application/json",
            "Accept: application/json"
          ),
        ));
        $result = curl_exec($curl);
        curl_close($curl);
       $data = json_decode($result, true);
        }else{
            $data = [
                'status' => 'error',
                'code' => 400,
                'message' => 'no se enviaron datos o datos incorrectos'
            ];
        }
        return $this->resjson($data);
    }

    public function consultar(Request $request){
        //recojer los datos por post
        $json = $request->get('json', null);
        //decodificar el json
        $params_array  = json_decode($json, true);
        $token = $request->headers->get('Authorization', null);
        $array = explode(' ', $token);
        $arraymarge = array_merge($params_array, $array);
        //comprobar y valdiar datos
        if($token != null){
        $json=  json_encode($arraymarge);
        $curl = curl_init();
            curl_setopt_array($curl, array(
          CURLOPT_URL =>$this->url."/consultar",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS =>$json,
          CURLOPT_HTTPHEADER => array(
            "Content-Type: application/json",
            "Accept: application/json"
          ),
        ));
        $result = curl_exec($curl);
         curl_close($curl);
         $data = json_decode($result, true);
        
        }else{
            $data = [
                'status' => 'error',
                'code' => 400,
                'message' => 'no se enviaron datos o datos incorrectos'
            ];
        }
        return $this->resjson($data);
    }
}
