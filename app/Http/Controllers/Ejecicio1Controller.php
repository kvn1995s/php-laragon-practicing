<?php

namespace App\Http\Controllers;

use App\FE\api_genera_xml;
use Illuminate\Http\Request;


class Ejecicio1Controller extends Controller
{
    public function index()
    {
        $alumno = array(
            'codigo'        =>  'AL001',
            'dni'           =>  '12345678',
            'nombres'       =>  'BRUCE',
            'apellidos'     =>  'WAYNE',
            'carrera'       =>  'DANZA'
        );

        $cursos = array(
            array(
                'periodo'       =>  '202310',
                'NRC'           =>  '1015',
                'nombre'        =>  'MATEMATICA BASICA',
                'creditos'      =>  3
            ),
            array(
                'periodo'       =>  '202310',
                'NRC'           =>  '3020',
                'nombre'        =>  'DANZA MODERNA',
                'creditos'      =>  3
            )
        );

        $objXML = new api_genera_xml();
        $objXML->crea_xml_alumno_cursos($alumno, $cursos);
        echo 'PROCESO TERMINADO';
    }
}
