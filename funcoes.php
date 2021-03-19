<?php


function buscaMunicipiosCadastrados($conn)
{
    $sqlMunicipios = "SELECT id_municipio_imovel_web FROM imovelweb_municipios";
    $resultadoMunicipios = mysqli_query($conn, $sqlMunicipios);
    $municipiosCadastrados =  $resultadoMunicipios->fetch_all();

    $arrayDeMunicipios = [];
    foreach ($municipiosCadastrados as $item) {

        array_push($arrayDeMunicipios, $item[0]);
    }

    return $arrayDeMunicipios;
}
function buscaEstadosCadastrados($conn)
{
    $sqlEstados = "SELECT id_uf_imovel_web FROM imovelweb_uf";
    $resultadoEstados = mysqli_query($conn, $sqlEstados);
    $EstadosCadastrados =  $resultadoEstados->fetch_all();

    $arrayDeEstados = [];
    foreach ($EstadosCadastrados as $item) {

        array_push($arrayDeEstados, $item[0]);
    }

    return $arrayDeEstados;
}
