<?php

namespace App\Http\Controllers;

use App\FE\api_genera_xml;
use Illuminate\Http\Request;

class EvaluacionP1Controller extends Controller
{
    public function index()
    {$alumno = array(
        'codigo'      => 'AL001',
        'nombres'     => 'JUAN JOSE SALAS ROJAS',            
        'dni'         => '76658255',
        'carrera'     => 'IGENIERIA'
    );

    $alumno = array(
        'codigo'      => 'AL002',
        'nombres'     => 'JORGE OSCAR ALVA ROMO',            
        'dni'         => '76655255',
        'carrera'     => 'MECANICA ELECTRICA'
    );

    $periodos = array(
        'periodo'     => '202210',
        'codigo'     => 'AL001',            
        'promerdio'   => '20'           
    );

    $periodos = array(
        'periodo'     => '202211',
        'codigo'     => 'AL002',            
        'promerdio'   => '18'           
    );
    $cursos = array(
    
    array(
        'NRC'         => '2036',  
        'nombre'      => 'CALCULO',
        'periodo'     => '202210',
        'codigo'      => 'AL002',
        'nota'        => '18'
        
    ),
   
    array(
        'NRC'         => '2033',  
        'nombre'      => 'FISICA',
        'periodo'     => '202210',
        'codigo'      => 'AL001',
        'nota'        => '20'
        
    ),
    array(
        'NRC'         => '2016',  
        'nombre'      => 'MATEMATICA I',
        'periodo'     => '202210',
        'codigo'      => 'AL002',
        'nota'        => '18'
    ),
    array(
            'NRC'         => '2032',  
            'nombre'      => 'QUIMICA',
            'periodo'     => '202210',
            'codigo'      => 'AL002',
            'nota'        => '20'
     )
    );

    $objXML=new api_genera_xml();
    $objXML->crea_xml_historico_academico($alumno,$periodos,$cursos);
    echo 'PROCESO TERMINADO';
}
}
