<?php
/**
 * Constantes del sistema
 */
const T_SEGUNDOS_INACTIVIDAD_PERMITIDO = 1200;

const ESTILO     = 'estilo.css';
const USUARIO = 'usuario';
const REGISTROS = 'registros';
const MODIFICACION = 'modificacion';
const CONSULTAS = 'consultas';

const EMAIL = 'soportesolicitudes.mantenimiento@correounivalle.edu.co';
const PASS = 'ManteUnivalle';
const EMAILSISTHIDRAULICO = '';
const EMAILSISTELECTRICO = '';
const EMAILSISTPLANTAFISICA = '';
const EMAILSISTMOBILIARIO = '';

const INICIAR_SESION = 'iniciar_sesion';
const OLVIDO_CONTRASENIA = 'olvido_contrasenia';
const OPERATION_LIST_ELECTRICO = 'listar_electrico';
const OPERATION_LIST_HIDRAULICO = 'listar_hidraulico';
const OPERATION_LIST_MOBILIARIO = 'listar_mobiliario';
const OPERATION_LIST_PLANTA = 'listar_planta';
const BUSCAR_DINAMICO = 'buscar_dinamico';
const OPERATION_BUSCAR = 'buscar_dinamicamente';
const OPERATION_SET = 'insertar';
const OPERATION_GET = 'buscar';
const OPERATION_DELETE = 'borrar';
const OPERATION_EDIT = 'modificar';
const OPERATION_LIST = 'listar';
const OPERATION_LIST_F = 'listarf';
const OPERATION_LIST_N = 'listarn';
const LIST_CONSULTAS_NOVEDAD = 'listarnovedad';
const OPERATION_LIST_MULTIPLE = 'listar_multiple';
const OPERATION_LIST_DIA = 'listardia';
const OPERATION_LIST_NORMAL = 'listar_normal';
const OPERATION_LIST_HISTORIAL = 'listar_historial';
const OPERATION_LIST_ORDENES = 'listar_ordenes';
const OPERATION_LIST_NOVEDADES = 'listar_novedad';
const OPERATION_LIST_NOVEDAD = 'listar_novedad';
const OPERATION_SALIR_SESION = 'salir_sesion';
const OPERATION_ADM_SUPERV = 'administrar_autorizado';
const OPERATION_NEW_USER = 'crear_nuevo_usuario';
const OPERATION_EDIT_DATA = 'cambiar_datos';
const OPERATION_ESTADISTICAS = 'estadisticas';
const OPERATION_ESTADISTICAS_EDIFICIOS = 'estadisticas_edificios';
const OPERATION_ESTADISTICAS_ESPACIOS = 'estadisticas_espacios';
const OPERATION_ESTADISTICAS_SISTEMA = 'estadisticas_sistema';
const OPERATION_ESTADISTICAS_OPERADOR = 'estadisticas_operador';
const OPERATION_ESTADISTICAS_NOVEDADES = 'estadisticas_novedades';
const OPERATION_NOVEDAD = 'novedades';

/*******************Mensajes******************/
const MJ_CONSULTA_EXITOSA = 'Se realizó correctamente la consulta ';
const MJ_CONSULTA_FALLIDA = 'No se pudo realizar la consulta ';
const MJ_PREPARAR_CONSULTA_FALLIDA = 'No se pudo preparar la consulta ';

const MJ_INSERT_REGISTROS_EXITOSA = 'Se creo con éxito la orden en el sistema.';
const MJ_INSERT_REGISTROS_FALLIDA = 'No se pudo crear la orden en el sistema';

const MJ_UPDATE_EXITOSA = 'La información de la orden seleccionada se ha actualizado correctamente';
const MJ_UPDATE_FALLIDA = 'No se pudo actualizar la información de la orden seleccionada';
const MJ_DELETE_EXITOSA = 'Las órdenes seleccionadas se han eliminado correctamente';
const MJ_DELETE_FALLIDA = 'No se pudieron eliminar las órdenes seleccionados';

const MS_ACTUALIZACION_FALLIDA = "Error";
const MJ_INSERT_USUARIO_EXITOSA = 'Se creo con éxito el usuario en el sistema';
const MJ_INSERT_USUARIO_FALLIDA = 'No se pudo crear el usuario en el sistema';
const MJ_ACTUALIZACION_USUARIO_EXITOSA = 'La información del usuario seleccionado se ha actualizado correctamente ';
const MJ_ACTUALIZACION_USUARIO_FALLIDA = 'No se pudo actualizar la información del usuario seleccionado ';
const MJ_ACTUALIZACION_DATA_USUARIO_EXITOSA = 'Se modifico correctamente sus datos';
const MJ_ACTUALIZACION_DATA_USUARIO_FALLIDA = 'No se pudo modificar sus datos';
const MJ_ELMINACION_USUARIO_EXITOSA = 'Los usuarios seleccionados se ha eliminado correctamente ';
const MJ_ELMINACION_USUARIO_FALLIDA = 'No se pudieron eliminar los usuarios seleccionados ';
const MJ_ERROR_NO_EXISTE_USUARIO = 'No se pudo realizar la operación. El usuario no existe.';
const MJ_ERROR_CONTRASENA_INCORRECTA = 'No se pudo realizar la operación. Contraseña incorrecta.';
const MJ_ERROR_LOGIN_REGISTRADO_POR_OTRO_USUARIO = 'No se pudo realizar la operación. Ya existe en la base de datos un usuario con el login digitado.';

const MJ_NO_CAMPOS_VACIOS = 'No pueden quedar campos obligatorios (*) vacíos ';
const MJ_REVISE_FORMULARIO = 'No se pudo realizar la operación. Revise el formulario por favor! ';
?>
