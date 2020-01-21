<?php
session_start();
if (!isset($_SESSION['role'])) {
    $_SESSION['role'] = '';
}

define('DIR_MODULES', './modules/');
define('DIR_TEMPLATE', './templates/');

require_once './core/functions.php';

include DIR_TEMPLATE . 'header.php';
include DIR_TEMPLATE . 'navbar.php';

$modul = $_GET['modul'] ?? '';
$modul_name = DIR_MODULES . $modul . '.php';

if ($_SESSION['role'] == '') {
    include DIR_MODULES . 'login.php';
}

switch ($modul) {
    case 'patient_file':
    case 'home':
    case 'logout':
    case 'login':
        include $modul_name;
        break;
    case 'scheduling':
        include './modules/nurse/scheduling.php';
        break;
    case 'createUser':
        include './modules/admin/createUser.php';
        break;
    case 'editUser':
        include './modules/admin/editUser.php';
        break;
    case 'showUsers':
        include './modules/admin/showUsers.php';
        break;
    case 'deleteUser':
        include './modules/admin/deleteUser.php';
        break;
    case 'createPatient':
        include './modules/nurse/createPatient.php';
        break;
    case 'viewPatient':
        include './modules/nurse/viewPatient.php';
        break;
    case 'doctorSchedule':
        include './modules/doctor/doctorSchedule.php';
        break;
    case 'patientHistory':
        include './modules/doctor/patientHistory.php';
        break;
    case 'invoice':
        include './modules/doctor/invoice.php';
        break;
    case 'reports':
        include './modules/reports/reports.php';
        break;
    case 'rPopulation':
        include './modules/reports/rPopulation.php';
        break;
    case 'rDoctors':
        include './modules/reports/rDoctors.php';
        break;
    case 'printXML':
        include './modules/reports/printXML.php';
        break;
    case 'printXMLGeneric':
        include './modules/reports/printXMLGeneric.php';
        break;
    default:
        include './modules/home.php';
        break;
}

include DIR_TEMPLATE . 'footer.php';
