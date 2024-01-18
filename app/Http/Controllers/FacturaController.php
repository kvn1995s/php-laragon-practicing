<?php

namespace App\Http\Controllers;

use App\FE\api_genera_xml;
use App\FE\total_en_letras;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class FacturaController extends Controller
{
    public function index()
    {

        $emisor = array(
            'tipodoc'               =>  '6',
            'nrodoc'                =>  '20123456789',
            'razon_social'          =>  'INSTITUTO SAN IGNACION DE LOYOLA',
            'nombre_comercial'      =>  'ISIL',
            'direccion'             =>  'REMOTO',
            'ubigeo'                =>  '010101',
            'departamento'          =>  'LIMA',
            'provincia'             =>  'LIMA',
            'distrito'              =>  'LIMA',
            'pais'                  =>  'PE',
            'usuario_secundario'    =>  'MODDATOS',
            'clave_usuario_secundario'  =>  'MODDATOS'
        );

        $cliente = array(
            'tipodoc'                   =>  '6',
            'nrodoc'                    =>  '20512110810',
            'razon_social'              =>  'PETER PARKER',
            'direccion'                 =>  'calle NY',
            'pais'                      =>  'PE'
        );

        $comprobante = array(
            'tipodoc'                   =>  '01', //factura: 01, boleta: 03, nc: 07, nd:08
            'serie'                     =>  'FREY',
            'correlativo'               =>  '777',
            'fecha_emision'             =>  date('Y-m-d'),
            'hora'                      =>  '00:00:00',
            'fecha_vencimiento'         =>  date('Y-m-d'),
            'moneda'                    =>  'PEN',
            'total_opgravadas'          =>  0.00,
            'total_opexoneradas'        =>  0.00,
            'total_opinafectas'         =>  0.00,
            'total_impbolsas'           =>  0.00,
            'total_oopgratuitas_1'      =>  0.00,
            'total_oopgratuitas_2'      =>  0.00,
            'igv'                       =>  0.00,
            'total'                     =>  0.00,
            'total_texto'               =>  '',
            'forma_pago'                =>  'Credito',
            'monto_pendiente'           =>  500.00
        );

        $cuotas = array(
            array(
                'cuota'                 =>  'Cuota001',
                'monto'                 =>  300.00,
                'fecha'                 =>  '2023-05-30'
            ),
            array(
                'cuota'                 =>  'Cuota002',
                'monto'                 =>  200.00,
                'fecha'                 =>  '2023-06-30'
            )
        );

        $detalle = array(

            array(
                'item'                  =>  1,
                'codigo'                =>  'PROD01',
                'descripcion'           =>  'IMPRESORA EPSON WIFI',
                'cantidad'              =>  2,
                'precio_unitario'       =>  800, //este precio ya incluye impuestos IGV:18%
                'valor_unitario'        =>  677.97, //este precio no incluye impuestos
                'tipo_precio'           =>  '01',
                'porcentaje_igv'        =>  18,
                'importe_total'         =>  1600.00, //cantidad * precio unitario
                'valor_total'           =>  1355.93, //cantidad * valor unitario
                'igv'                   =>  244.07,
                'unidad'                =>  'NIU',
                'bolsa_plastica'        =>  'NO',
                'total_impuesto_bolsas' =>  0.00,

                'tipo_afectacion_igv'   =>  '10', //GRAVADOS: 10, EXONERADOS:20, INAFECTOS: 30
                'codigo_tipo_tributo'   =>  '100',
                'tipo_tributo'          =>  'VAT',
                'nombre_tributo'        =>  'IGV'
            ),
            array(
                'item'                  =>  2,
                'codigo'                =>  'PROD02',
                'descripcion'           =>  'POLLO X 1KG',
                'cantidad'              =>  2,
                'precio_unitario'       =>  10.00, //este precio ya incluye impuestos IGV:18%
                'valor_unitario'        =>  8.47, //este precio no incluye impuestos
                'tipo_precio'           =>  '01',
                'porcentaje_igv'        =>  0,
                'importe_total'         =>  20.00, //cantidad * precio unitario
                'valor_total'           =>  16.94, //cantidad * valor unitario
                'igv'                   =>  3.06,
                'unidad'                =>  'NIU',
                'bolsa_plastica'        =>  'NO',
                'total_impuesto_bolsas' =>  0.00,

                'tipo_afectacion_igv'   =>  '20', //GRAVADOS: 10, EXONERADOS:20, INAFECTOS: 30
                'codigo_tipo_tributo'   =>  '9997',
                'tipo_tributo'          =>  'VAT',
                'nombre_tributo'        =>  'EXO'
            ),
            array(
                'item'                  =>  3,
                'codigo'                =>  'PROD03',
                'descripcion'           =>  'PLATANO X 1KG',
                'cantidad'              =>  1,
                'precio_unitario'       =>  5.00, //este precio ya incluye impuestos IGV:18%
                'valor_unitario'        =>  4.24, //este precio no incluye impuestos
                'tipo_precio'           =>  '01',
                'porcentaje_igv'        =>  0,
                'importe_total'         =>  5.00, //cantidad * precio unitario
                'valor_total'           =>  4.24, //cantidad * valor unitario
                'igv'                   =>  0.76,
                'unidad'                =>  'NIU',
                'bolsa_plastica'        =>  'NO',
                'total_impuesto_bolsas' =>  0.00,

                'tipo_afectacion_igv'   =>  '30', //GRAVADOS: 10, EXONERADOS:20, INAFECTOS: 30
                'codigo_tipo_tributo'   =>  '9998',
                'tipo_tributo'          =>  'FRE',
                'nombre_tributo'        =>  'INA'
            )

        );

        //Inicializar los totales
        $total_opgravadas = 0.00;
        $total_opexoneradas = 0.00;
        $total_opinafectas = 0.00;
        $total_impbolsas = 0.00;
        $igv = 0.00;
        $total = 0.00;
        $op_gratuitas1 = 0.00;
        $op_gratuitas2 = 0.00;

        foreach ($detalle as $key => $value) {
            if ($value['tipo_afectacion_igv'] == 10) { //OP GRAVADAS
                $total_opgravadas += $value['valor_total'];
            }

            if ($value['tipo_afectacion_igv'] == 20) { //OP EXONERADAS
                $total_opexoneradas += $value['valor_total'];
            }

            if ($value['tipo_afectacion_igv'] == 30) { //OP INAFECTAS
                $total_opinafectas += $value['valor_total'];
            }

            $igv += $value['igv'];
            $total_impbolsas += $value['total_impuesto_bolsas'];
            $total += $value['importe_total'] + $total_impbolsas;
        }

        $comprobante['total_opgravadas'] = $total_opgravadas;
        $comprobante['total_opexoneradas'] = $total_opexoneradas;
        $comprobante['total_opinafectas'] = $total_opinafectas;
        $comprobante['total_impbolsas'] = $total_impbolsas;
        $comprobante['total_opgratuitas_1'] = $op_gratuitas1;
        $comprobante['total_opgratuitas_2'] = $op_gratuitas2;
        $comprobante['igv'] = $igv;
        $comprobante['total'] = $total;
        $total_en_letras = new total_en_letras();
        $comprobante['total_texto'] = $total_en_letras->CantidadEnLetra($total);

        //echo '<h1>Hola Mundo ISIL</h1>' . $comprobante['monto_pendiente'];

        //PARTE I GENERA XML - SUNAT
        $objXML = new api_genera_xml();
        $resultado = $objXML->crea_xml_invoice();

        if ($resultado == 1) {
            echo 'EXITO SE CREO EL XML';
        } else {
            echo 'PROBLEMAS';
        }
        //nombre o nomenclatura SUNAT
        $nombreXML = $emisor ['nrodoc'] . '-' . $comprobante ['tipodoc'] . '-' .$comprobante
        ['serie'] . '-' .  $comprobante['correlativo'];
        $rutaXML = 'cpe/xml/';

        $resultado = $objXML->crea_xml_invoice($rutaXML . $nombreXML,$emisor,$cliente,
        $comprobante,$detalle,$cuotas);

        if($resultado == 1){
            echo 'EXITO SE CREO EL XML';
        }else{
            echo 'PROBLEMAS';
        }


        //PARTE II CONSUMO WEB SERVICE SUNAT
        $objCPE = new api_cpe();
        echo '</br> PARTE II - CONSUMO  WS SUNAT';
        $objCPE->enviar_invoice ($emisor, $nombreXML);


    }
}
