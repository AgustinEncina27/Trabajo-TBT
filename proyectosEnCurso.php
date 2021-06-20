<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Proyectos en Curso</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <header>
        <div class="contendor">
            <a href="/principal.php">Menu Principal</a>
            <a href="/VS CDE PHP">Cerrar Sesión</a>
        </div>
    </header>
    <?php
    require 'database.php';
    $sql = "SELECT pro.nombre,pro.dni,pro.fecha,eta.nombreetapa,it.nom_item,it.dni
            from TPBD_PARTICIPANTES par
            inner join TPBD_PROYECTO pro on pro.dni= par.dni
            inner join TPBD_ETAPAADSESARROLLAR etade on etade.id_proyecto=pro.id_proyecto
            inner join TPBD_ETAPA eta on eta.id_etapa=etade.id_etapa
            inner join TPBD_ITEMS it on it.id_etapa=etade.id_etapa and it.id_etapaADesarrollar=etade.id_etapaADesarrollar and it.id_proyecto=etade.id_proyecto
            inner join TPBD_ESTADO est on est.id_estado=it.id_estado where ESTADOETAPA(etade.id_etapaadesarrollar)='En Curso' AND it.id_estado =2";
    $unir = oci_parse($Oracle, $sql);
    oci_execute($unir);

    print "<table border='1' class='contendor-tabla'> <br>\n";
    print "<tr>\n
      <td> NOMBRE DEL PROYECTO </td>\n
      <td> PROPIETARIO DEL PROYECTO </td>\n
      <td> FECHA DEL PROYECTO </td>\n
      <td> NOMBRE DE ETAPA </td>\n
      <td> NOMBRE DEL ITEM </td>\n
      <td> RESPONSABLE DEL ITEM </td>\n
      </tr>\n";

    while ($fila = oci_fetch_array($unir, OCI_NUM + OCI_RETURN_NULLS)) {
        print "<tr>\n";
        foreach ($fila as $elemento) {
            print "<td>" . ($elemento !== null ? htmlentities($elemento, ENT_QUOTES) : "") . "</td>\n";
        }
        print "</tr>\n";
    }
    print "</table>\n";

    oci_free_statement($unir);
    require 'cerrarConexion.php';
    ?>
</body>

</html>