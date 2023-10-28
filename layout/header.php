<?php
$url = "http://matriz_riesgo.test/";
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Patrimonio | Dashboard</title>

    <link href="<?=$url?>css/bootstrap.min.css" rel="stylesheet">
    <link href="<?=$url?>font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="<?=$url?>css/plugins/dataTables/datatables.min.css" rel="stylesheet">

    <!-- Toastr style -->
    <link href="<?=$url?>css/plugins/toastr/toastr.min.css" rel="stylesheet">

    <!-- Gritter -->
    <link href="<?=$url?>js/plugins/gritter/jquery.gritter.css" rel="stylesheet">

    <link href="<?=$url?>css/animate.css" rel="stylesheet">
    <link href="<?=$url?>css/style.css" rel="stylesheet">

</head>

<body>
    <div id="wrapper">
        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav metismenu" id="side-menu">
                    <li class="nav-header">
                        <div class="dropdown profile-element">
                            <img alt="image" class="rounded-circle" style="width: 40px; height: 40px;" src="<?=$url?>img/user.jpg" />
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <span class="block m-t-xs font-bold">Brian Dextre</span>
                                <span class="text-muted text-xs block">Administrador <b class="caret"></b></span>
                            </a>
                            <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                <!--<li class="dropdown-divider"></li>-->
                                <li><a class="dropdown-item" href="login.html">Cerrar sesión</a></li>
                            </ul>
                        </div>
                        <div class="logo-element">
                            IN+
                        </div>
                    </li>
                    <li>
                        <a href="<?=$url?>"><i class="fa fa-home"></i> <span class="nav-label">Inicio</span></a>
                    </li>
                    <li>
                        <a href="<?=$url?>pages/matriz"><i class="fa fa-table"></i> <span class="nav-label">Matriz de riesgo</span></a>
                    </li>
                    <li>
                        <a href="<?=$url?>pages/controles_iso"><i class="fa fa-shield"></i> <span class="nav-label">ISO 27002</span></a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-wrench"></i> <span class="nav-label">Mantenimiento</span>
                            <span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li class="active"><a href="#">Usuarios</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
        <div id="page-wrapper" class="gray-bg dashbard-1">
            <div class="row border-bottom">
                <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                    <div class="navbar-header">
                        <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
                    </div>
                    <ul class="nav navbar-top-links navbar-right">
                        <li style="padding: 20px">
                            <span class="m-r-sm text-muted welcome-message"><?=$title_navbar?></span>
                        </li>
                        <li>
                            <a href="logout">
                                <i class="fa fa-sign-out"></i> Cerrar sesión
                            </a>
                        </li>
                    </ul>

                </nav>
            </div>