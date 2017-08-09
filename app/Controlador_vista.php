<?php

/**
 * Clase que controla lo que va ser visto por el usuario. Controla la visualización
 * de la interfaz de usuario.
**/
class Controlador_vista
{
    //array que guarda el diccionario de rutas del menu y formularios
    var $diccionario = array();

    /**
     * Metodo constructora del Controlador_vista.
     * @global array $diccionario
    **/
    function __construct() {

        global $diccionario;

        $diccionario = array(
            'links_menu'=>array(
                'SALIR'=>'index.php?action='.OPERATION_SALIR_SESION,
                'SET_REGISTROS'=>'index.php?action='.OPERATION_SET.'_'.REGISTROS,
                'LIST_MODIFICACION'=>'index.php?action='.OPERATION_LIST.'_'.MODIFICACION,
                'LIST_CONSULTAS'=>'index.php?action='.OPERATION_LIST.'_'.CONSULTAS,
                'LIST_CONSULTAS_F'=>'index.php?action='.OPERATION_LIST_F.'_'.CONSULTAS,
                'LIST_MODIFICACION_N'=>'index.php?action='.OPERATION_LIST_N.'_'.MODIFICACION,
                'LIST_CONSULTAS_MULTIPLE'=>'index.php?action='.OPERATION_LIST_MULTIPLE.'_'.CONSULTAS,
                'LIST_BUSCAR'=>'index.php?action='.BUSCAR_DINAMICO,
                'LIST_CONSULTAS_DIA' => 'index.php?action='.OPERATION_LIST_DIA.'_'.CONSULTAS,
                'LIST_ELECTRICO'=>'index.php?action='.OPERATION_LIST_ELECTRICO.'_'.CONSULTAS,
                'LIST_HIDRAULICO'=>'index.php?action='.OPERATION_LIST_HIDRAULICO.'_'.CONSULTAS,
                'LIST_MOBILIARIO'=>'index.php?action='.OPERATION_LIST_MOBILIARIO.'_'.CONSULTAS,
                'LIST_PLANTA'=>'index.php?action='.OPERATION_LIST_PLANTA.'_'.CONSULTAS,
                'LIST_CONSULTAS_NORMAL'=>'index.php?action='.OPERATION_LIST_NORMAL.'_'.CONSULTAS,
                'LIST_HISTORIAL'=>'index.php?action='.OPERATION_LIST_HISTORIAL,
                'LIST_ORDENES'=>'index.php?action='.OPERATION_LIST_ORDENES,
                'LIST_ESTADISTICAS_EDIFICIOS'=>'index.php?action='.OPERATION_ESTADISTICAS_EDIFICIOS,
                'LIST_ESTADISTICAS_ESPACIOS'=>'index.php?action='.OPERATION_ESTADISTICAS_ESPACIOS,
                'LIST_ESTADISTICAS_SISTEMA' =>'index.php?action='.OPERATION_ESTADISTICAS_SISTEMA,
                'LIST_ESTADISTICAS_OPERADOR' =>'index.php?action='.OPERATION_ESTADISTICAS_OPERADOR,
                'LIST_ESTADISTICAS_NOVEDADES' =>'index.php?action='.OPERATION_ESTADISTICAS_NOVEDADES,
                'LIST_NOVEDADES' =>'index.php?action='.OPERATION_NOVEDAD,
                'ADM_USERS'=>'index.php?action='.OPERATION_ADM_SUPERV.'_'.USUARIO,
                'EDIT_DATA'=>'index.php?action='.OPERATION_EDIT_DATA
                ),
            'form_actions'=>array(
                'FORM_INICIAR_SESION'=>'index.php?action='.INICIAR_SESION,
                'FORM_EDIT_MODIFICACION'=>'index.php?action='.OPERATION_EDIT.'_'.MODIFICACION,
                'FORM_NEW_USER'=>'index.php?action='.OPERATION_NEW_USER
                )
        );
    }

    /**
    *funcion que permite cargar de forma dinamica las librerias de la aplicacion web
    *@param $module. Hace referencia la modulo que se carga una vez ejecutada una ruta
    **/
    function crear_enlace_libreria($module)
    {
        $link = "<script type='text/javascript' src='js/".$module."_functions.js?v=2.6'>"
                . "</script>";

        return $link;
    }

    /**
     * Función que permite conseguir y alamacenar como un string el menu de
     * operaciones adicional dependiendo del perfil del usuario.
     * @param string $perfil, Cadena que hace referencia la perfil de usuario
     * con acceso al sistema de inventario.
     * @return string
    **/
    function conseguir_operaciones_add($perfil = 'normal')
    {
        if(strcmp($perfil, 'sanfernando') == 0){
            $file = dirname(__FILE__).'/templates/vistas_menu_usuario/'.'m_operaciones_add_sanfernando.html';
        }
        else if((strcmp($perfil, 'electrico') == 0) || (strcmp($perfil, 'hidraulico') == 0) || (strcmp($perfil, 'mobiliario') == 0) || (strcmp($perfil, 'planta') == 0)){
            $file = dirname(__FILE__).'/templates/vistas_menu_usuario/'.'m_operaciones_add_jefe.html';
        }
        else if(strcmp($perfil, 'jefe') == 0){
            $file = dirname(__FILE__).'/templates/vistas_menu_usuario/'.'m_operaciones_add_jefeTodos.html';
        }
        else if(strcmp($perfil, 'admin') == 0){
        	$file = dirname(__FILE__).'/templates/vistas_menu_usuario/'.'m_operaciones_add_admin.html';
        }
        else{
            $file = dirname(__FILE__).'/templates/vistas_menu_usuario/'.'m_operaciones_add_normal.html';
        }

        $template = file_get_contents($file);

        return $template;
    }

    /**
     * Función que permite conseguir la plantilla de una vista y guardarla en
     * un string.
     * @param string $module, Cadena que hace referencia al modulo al cual
     * pertenece la vista a visualizar.
     * @param string $operation, Cadena que hace referencia a la operación que
     * permite realizar la vista que se va a visualizar.
     * @return string.
    **/
    function conseguir_plantilla($module='registros', $operation='')
    {
        if(strcmp($module, 'layout1') == 0 || strcmp($module, 'layout2') == 0 )
        {
            $file = dirname(__FILE__).'/templates/'.$module.'.html';
        }
        else
        {
            $file = dirname(__FILE__).'/templates/vistas_mdl_'.$module.'/'
                    .$module.'_'.$operation.'.html';
        }

        $template = file_get_contents($file);

        return $template;
    }

    /**
     * Función que permite replazar dinamicamente informacion en cada página
     * html.
     * @param string $html, Cadena que que contiene el html de la página a
     * visualizar.
     * @param array $data, Array que contiene la información a remplazar.
     * @return string
    **/
    function representar_datos_dinamica($html, $data)
    {
        foreach ($data as $clave=>$valor)
        {
            $html = str_replace('{'.$clave.'}', $valor, $html);
        }

        return $html;
    }

    /**
     * Función que retorna y permite visualizar la página requerida por el
     * usuario.
     * @global array $diccionario
     * @param string $perfil, Cadena que hace referencia al perfil o privilegios
     * del usuario.
     * @param string $module, Cadena que hace referencia al modulo al cual
     * pertenece la vista a visualizar.
     * @param string $operation, Cadena que hace referencia a la operación que
     * permite realizar la vista que se va a visualizar.
     * @param array $data, Arreglo que contiene la información que se va a
     * reemplazar dinámicamente.
    **/
    function retornar_vista($perfil, $module, $operation, $data=array()) {

        global $diccionario;

        if(strcmp($module, USUARIO) == 0 &
                (strcmp($operation, INICIAR_SESION) == 0 || strcmp($operation, OLVIDO_CONTRASENIA) == 0))
        {
            $html = $this->conseguir_plantilla('layout1', '');
            $html = str_replace('{contenido}',
                    $this->conseguir_plantilla($module, $operation), $html);
            $html = str_replace('{librerias_adicionales}', '', $html);
            $html = $this->representar_datos_dinamica($html,
            $diccionario['form_actions']);
            $html = $this->representar_datos_dinamica($html, $data);

        }
        else
        {
            $html = $this->conseguir_plantilla('layout2', '');
            $html = str_replace('{operaciones}',
                    $this->conseguir_operaciones_add($perfil), $html);
            $html = str_replace('{librerias_adicionales}',
                    $this->crear_enlace_libreria($module),
                    $html);
            $html = str_replace('{contenido}',
                    $this->conseguir_plantilla($module, $operation), $html);
            $html = $this->representar_datos_dinamica($html,
                    $diccionario['form_actions']);
            $html = $this->representar_datos_dinamica($html,
                    $diccionario['links_menu']);
            $html = $this->representar_datos_dinamica($html, $data);
        }

        print $html;
    }
}
?>
