<?php

namespace App\FE;

use DOMDocument;

class api_genera_xml{

    public function crea_xml_invoice()
    {
        $doc = new DOMDocument(); //clase que me permite gestionar XML
        $doc->preserveWhiteSpace = true;
        $doc->encoding = 'utf-8';
        $doc->formatOutput = false;

        $xml = '<?xml version="1.0" encoding="UTF-8"?>
                <factura>
                    <fecha>2023-04-22</fecha>
                    <total>5000</total>
                    <cliente>Fercho</cliente>
                    <producto>
                        <nombre>IPHONE 14 PRO MAX MORADO 256GB</nombre>
                        <codigo>PRODI</codigo>
                    </producto>
                </factura>';

        $doc->loadXML($xml); //cargo o convierto el texto a XML
        $doc->save('cpe/xml/ejemplo1.XML'); //guardando el XML en disco
        return 1;
    }

    public function crea_xml_alumno_cursos($alumno, $cursos)
    {
        $doc = new DOMDocument(); //clase que me permite gestionar XML
        $doc->preserveWhiteSpace = true;
        $doc->encoding = 'utf-8';
        $doc->formatOutput = false;

        $xml = '<?xml version="1.0" encoding="UTF-8"?>
                <alumno>
                    <codigo>' . $alumno['codigo'] . '</codigo>
                    <dni>' . $alumno['dni'] . '</dni>
                    <nombres>' . $alumno['nombres'] . '</nombres>
                    <apellidos>' . $alumno['apellidos'] . '</apellidos>
                    <carrera>' . $alumno['carrera'] . '</carrera>';

        foreach ($cursos as $key => $curso) {
            $xml = $xml . '
                    <curso>
                        <periodo>' . $curso['periodo'] . '</periodo>
                        <NRC>' . $curso['NRC'] . '</NRC>
                        <nombre>' . $curso['nombre'] . '</nombre>
                        <creditos>' . $curso['creditos'] . '</creditos>
                    </curso>';
        }

        $xml = $xml . '
        </alumno>';

        $doc->loadXML($xml); //cargo o convierto el texto a XML
        $doc->save('cpe/xml/alumno_cursos.XML'); //guardando el XML en disco
        return 1;
    }
    public function crea_xml_profesor_cursos($profesor,$cursos)
    {
        $doc = new DOMDocument(); //clase que me permite gestionar XML
        $doc->preserveWhiteSpace = true;
        $doc->encoding = 'utf-8';
        $doc->formatOutput = false;

        $xml = '<?xml version="1.0" encoding="UTF-8"?>
         <profesor>
            <codigo>'  . $profesor['codigo'] .  '</codigo>
            <nombres>'. $profesor['nombres'] .  '</nombres>
            <apellidos>' . $profesor['apellidos']. '</apellidos>
            <DNI>'       . $profesor['DNI']  . '</DNI>	
            <especialidad>'.$profesor['especialidad'] .'</especialidad>';
            foreach ($cursos as $key => $curso) {
                $xml = $xml .'
             <curso>
                <periodo>' . $curso['periodo'] .'</periodo>
                <NRC>'. $curso['NRC'] .'</NRC>
                <nombre>' . $curso['nombre'] . '</nombre>
                <creditos>' . $curso['creditos'] . '</creditos>
                <horario>' . $curso['horario'] . '</horario>
                <horas>' . $curso['horas'] .'</horas>
               <modalidad>' . $curso['modalidad'] . '</modalidad>
             </curso>';
            }
        $xml = $xml . '
        </profesor>';
        $doc->loadXML($xml); //cargo o convierto el texto a XML
        $doc->save('cpe/xml/profesor_cursos.XML'); //guardando el XML en disco
        return 1;
    }
    public function crea_xml_historico_academico ($alumno,$periodos,$cursos)
    {
        $doc = new DOMDocument(); //clase que me permite gestionar XML
        $doc->preserveWhiteSpace = true;
        $doc->encoding = 'utf-8';
        $doc->formatOutput = false;

        $xml = '<?xml version="1.0" encoding="UTF-8"?>
                <alumno>
                    <codigo>' . $alumno['codigo'] . '</codigo>
                    <dni>' . $alumno['dni'] . '</dni>
                    <nombres_apellidos>' . $alumno['nombres'] . '</nombres_apellidos>                    
                    <carrera>' . $alumno['carrera'] . '</carrera>        
                
                <periodos>
                <periodo>' . $periodos['periodo'] .'</periodo>
                <codigo>' .  $periodos['codigo'] . '</codigo>
                <promerdio>' . $periodos['promerdio'] . '</promerdio>';
                foreach ($cursos as $key => $curso) {
                    $xml = $xml .'
                 <curso>                    
                    <NRC>'. $curso['NRC'] .'</NRC>
                    <nombre>' . $curso['nombre'] . '</nombre>                    
                    <periodo>' . $curso['periodo'] .'</periodo>
                    <codigo>' . $curso['codigo'] . '</codigo>
                   <nota>' . $curso['nota'] . '</nota>
                 </curso>';
                 }
                 $xml = $xml . '
                 </periodos>;
             </alumno>';
        $doc->loadXML($xml); //cargo o convierto el texto a XML
        $doc->save('cpe/xml/historico_academico.XML'); //guardando el XML en disco
        return 1;
    

}
}
?>
