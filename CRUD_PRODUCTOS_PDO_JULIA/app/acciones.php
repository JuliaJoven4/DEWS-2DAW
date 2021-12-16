<?php
include_once "Producto.php";

function accionBorrar ($pro){    
    $db = AccesoDatos::getModelo();
    $producto = $db->borrarProducto($pro);
}

function accionTerminar(){
    AccesoDatos::closeModelo();
    session_destroy();
}
 
function accionAlta(){
    $producto = new Producto();
    $producto->DESCRIPCION  = "";
    $producto->PRODUCTO_NO  = "";
    $producto->PRECIO_ACTUAL   = "";
    $producto->STOCK_DISPONIBLE = "";
    $orden= "Nuevo";
    include_once "layout/formulario.php";
}

function accionDetalles($pro){
    $db = AccesoDatos::getModelo();
    $producto = $db->getProducto($pro);
    $orden = "Detalles";
    include_once "layout/formulario.php";
}


function accionModificar($pro){
    $db = AccesoDatos::getModelo();
    $producto = $db->getProducto($pro);
    $orden="Modificar";
    include_once "layout/formulario.php";
}

function accionPostAlta(){
    limpiarArrayEntrada($_POST); //Evito la posible inyección de código
    $producto = new Producto();
    $producto->DESCRIPCION  = $_POST['DESCRIPCION'];
    $producto->PRODUCTO_NO   = $_POST['PRODUCTO_NO'];
    $producto->PRECIO_ACTUAL   = $_POST['PRECIO_ACTUAL'];
    $producto->STOCK_DISPONIBLE = $_POST['STOCK_DISPONIBLE'];
    $db = AccesoDatos::getModelo();
    $db->addProducto($producto);
    
}

function accionPostModificar(){
    limpiarArrayEntrada($_POST); //Evito la posible inyección de código
    $producto = new Producto();
    $producto->DESCRIPCION  = $_POST['DESCRIPCION'];
    $producto->PRODUCTO_NO   = $_POST['PRODUCTO_NO'];
    $producto->PRECIO_ACTUAL   = $_POST['PRECIO_ACTUAL'];
    $producto->STOCK_DISPONIBLE = $_POST['STOCK_DISPONIBLE'];
    $db = AccesoDatos::getModelo();
    $db->modProducto($producto);
    
}