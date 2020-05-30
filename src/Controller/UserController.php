<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints\Email;

class UserController extends AbstractController
{
    public $url;

    public function __construct(){
        $this->url = 'http://localhost/prueba_epayco/php/pruebaEpaycoClient/public';
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
            'path' => 'src/Controller/UserController.php',
        ]);
    }
    public function registro(Request $request){
        //recojer los datos por post
        $json = $request->get('json', null);
        //decodificar el json
        $params = json_decode($json);
        //comprobar y valdiar datos
        if($json != null){
            $name = (!empty($params->name)) ? $params->name: null;
            $documento = (!empty($params->documento)) ? $params->documento: null;
            $email = (!empty($params->email)) ? $params->email: null;
            $celular = (!empty($params->celular)) ? $params->celular: null;
            $password = (!empty($params->password)) ? $params->password: null;

            $validator = Validation::createValidator();
            $validate_email = $validator->validate($email, [
                new Email()
            ]);

        if(!empty($email) && count($validate_email) ==0 
            && !empty($name) && !empty($documento) 
            && !empty($celular)  && !empty($password))
        {
        $params_array  = json_decode($json, true);
        $params_array = array_map('trim', $params_array);
        $json=  json_encode($params_array);
        $curl = curl_init();
            curl_setopt_array($curl, array(
          CURLOPT_URL => "http://localhost/prueba_epayco/php/pruebaEpayco/public/registro",
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
        $result_json = json_decode($result, true);
        $data = $result_json;
        }else{
                $data = [
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'no se enviaron datos o datos incorrectos'
                ];
            }
        }else{
            $data = [
                'status' => 'error',
                'code' => 400,
                'message' => 'no se enviaron datos o datos incorrectos'
            ];
        }
        return $this->resjson($data);
    }

    public function login(Request $request){
     //recojer los datos por post
     $json = $request->get('json', null);
     //decodificar el json
     $params = json_decode($json);
     //comprobar y valdiar datos
        if($json != null){
            $email = (!empty($params->email)) ? $params->email: null;
            $password = (!empty($params->password)) ? $params->password: null;
            $gettoken = (!empty($params->gettoken)) ? $params->gettoken: null;

            $validator = Validation::createValidator();
            $validate_email = $validator->validate($email, [
                new Email()
            ]);

        if(!empty($email) && count($validate_email) ==0  && !empty($password))
        {
            $params_array  = json_decode($json, true);
            $params_array = array_map('trim', $params_array);
            $json=  json_encode($params_array);
            $curl = curl_init();
            curl_setopt_array($curl, array(
              CURLOPT_URL => "http://localhost/prueba_epayco/php/pruebaEpayco/public/login",
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "POST",
              CURLOPT_POSTFIELDS =>$json,
              CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json"
              ),
            ));
            
            $data = curl_exec($curl);
            
            curl_close($curl);

        }
        else{
            $data = [
                'status' => 'error',
                'code' => 200,
                'message' => 'no se enviaron datos o datos incorrectos'
            ];
        }
    }
    return $this->resjson($data);
}


}
