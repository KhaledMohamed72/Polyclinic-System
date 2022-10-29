
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title> Create Prescription  | Doctorly - Patient Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Hospital Management System" name="description" />
    <meta content="Doctorly" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="https://doctorly.themesbrand.website/assets/images/favicon.ico">
    <link rel="stylesheet" type="text/css" href="https://doctorly.themesbrand.website/assets/libs/select2/select2.min.css">
    <!-- App css -->
    <link href="https://doctorly.themesbrand.website/assets/css/bootstrap-dark.min.css" id="bootstrap-dark" rel="stylesheet" type="text/css" />
    <link href="https://doctorly.themesbrand.website/assets/css/bootstrap.min.css" id="bootstrap-light" rel="stylesheet" type="text/css" />
    <link href="https://doctorly.themesbrand.website/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="https://doctorly.themesbrand.website/assets/css/app-rtl.min.css" id="app-rtl" rel="stylesheet" type="text/css" />
    <link href="https://doctorly.themesbrand.website/assets/css/app-dark.min.css" id="app-dark" rel="stylesheet" type="text/css" />
    <link href="https://doctorly.themesbrand.website/assets/css/app.min.css" id="app-light" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="https://doctorly.themesbrand.website/assets/libs/toastr/toastr.min.css">


</head>


<body data-topbar="dark" data-layout="horizontal">

<div id="preloader">
    <div id="status">
        <div class="spinner-chase">
            <div class="chase-dot"></div>
            <div class="chase-dot"></div>
            <div class="chase-dot"></div>
            <div class="chase-dot"></div>
            <div class="chase-dot"></div>
            <div class="chase-dot"></div>
        </div>
    </div>
</div>
<!-- Begin page -->
<div id="layout-wrapper">
    <header id="page-topbar">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box">
                    <a href="https://doctorly.themesbrand.website" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="https://doctorly.themesbrand.website/assets/images/logo-dark.png" alt="" height="22">
                    </span>
                        <span class="logo-lg">
                        <img src="https://doctorly.themesbrand.website/assets/images/logo-dark1.png" alt="" height="17">
                    </span>
                    </a>
                    <a href="https://doctorly.themesbrand.website" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="https://doctorly.themesbrand.website/assets/images/logo-light.png" alt="" height="22">
                    </span>
                        <span class="logo-lg">
                        <img src="https://doctorly.themesbrand.website/assets/images/logo-light1.png" alt="" height="19">
                    </span>
                    </a>
                </div>
                <button type="button" class="btn btn-sm px-3 font-size-16 d-lg-none header-item waves-effect waves-light"
                        data-toggle="collapse" data-target="#topnav-menu-content">
                    <i class="fa fa-fw fa-bars"></i>
                </button>
            </div>
            <div class="d-flex">

                <div class="dropdown d-none d-lg-inline-block ml-1">
                    <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                        <i class="bx bx-fullscreen"></i>
                    </button>
                </div>
                <div class="dropdown d-inline-block">
                    <button type="button" class="btn header-item noti-icon waves-effect"
                            id="page-header-notifications-dropdown" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                        <i class="bx bx-bell bx-tada"></i>
                        <span class="badge badge-danger badge-pill">7</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0"
                         aria-labelledby="page-header-notifications-dropdown">
                        <div class="p-3">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h6 class="m-0"> Notifications</h6>
                                </div>
                                <div class="col-auto">
                                    <a href="https://doctorly.themesbrand.website/notification-list" class="small"> View All</a>
                                </div>
                            </div>
                        </div>
                        <div data-simplebar class="notification-list-scroll overflow-auto" style="max-height: 230px;">

                            <a href="https://doctorly.themesbrand.website/notification-list" class="text-reset notification-item bg-light ">
                                <div class="media">
                                    <img src="https://doctorly.themesbrand.website/assets/images/users/avatar-1.jpg"
                                         class="mr-3 rounded-circle avatar-xs" alt="user-pic">
                                    <div class="media-body">
                                        <h6 class="mt-0 mb-1">Leone Trantow</h6>
                                        <div class="font-size-12 text-muted">
                                            <p class="mb-1">Appointment Added</p>
                                            <p class="mb-0"><i class="mdi mdi-clock-outline"></i> 18 hours ago
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <a href="https://doctorly.themesbrand.website/notification-list" class="text-reset notification-item bg-light ">
                                <div class="media">
                                    <img src="https://doctorly.themesbrand.website/assets/images/users/avatar-2.jpg"
                                         class="mr-3 rounded-circle avatar-xs" alt="user-pic">
                                    <div class="media-body">
                                        <h6 class="mt-0 mb-1">Dr. Viviane Hoppe</h6>
                                        <div class="font-size-12 text-muted">
                                            <p class="mb-1">Appointment Cancel</p>
                                            <p class="mb-0"><i class="mdi mdi-clock-outline"></i> 1 day ago </p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <a href="https://doctorly.themesbrand.website/notification-list" class="text-reset notification-item bg-light ">
                                <div class="media">
                                    <img src="https://doctorly.themesbrand.website/assets/images/users/avatar-3.jpg"
                                         class="mr-3 rounded-circle avatar-xs" alt="user-pic">
                                    <div class="media-body">
                                        <h6 class="mt-0 mb-1">test Doctorly</h6>
                                        <div class="font-size-12 text-muted">
                                            <p class="mb-1">Invoice  Create</p>
                                            <p class="mb-0"><i class="mdi mdi-clock-outline"></i> 2 days ago </p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <a href="https://doctorly.themesbrand.website/notification-list" class="text-reset notification-item bg-light ">
                                <div class="media">
                                    <img src="https://doctorly.themesbrand.website/assets/images/users/avatar-4.jpg"
                                         class="mr-3 rounded-circle avatar-xs" alt="user-pic">
                                    <div class="media-body">
                                        <h6 class="mt-0 mb-1">test Doctorly</h6>
                                        <div class="font-size-12 text-muted">
                                            <p class="mb-1">Appointment completed successfully</p>
                                            <p class="mb-0"><i class="mdi mdi-clock-outline"></i> 2 days ago </p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="p-2 border-top">
                            <a class="btn btn-sm btn-link font-size-14 btn-block text-center" href="https://doctorly.themesbrand.website/notification-list">
                                <i class="mdi mdi-arrow-right-circle mr-1"></i> View More..
                            </a>
                        </div>
                    </div>
                </div>
                <div class="dropdown d-inline-block">
                    <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img class="rounded-circle header-profile-user"
                             src="https://doctorly.themesbrand.website/storage/images/users/1661089646.jpg"
                             alt="Avatar">
                        <span class="d-none d-xl-inline-block ml-1">Arthuro</span>
                        <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <!-- item-->
                        <a class="dropdown-item" href="https://doctorly.themesbrand.website/profile-view"><i
                                class="bx bx-user font-size-16 align-middle mr-1"></i> Profile</a>
                        <a class="dropdown-item d-block" href="https://doctorly.themesbrand.website/change-password"><i
                                class="bx bx-wrench font-size-16 align-middle mr-1"></i> Change Password</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-danger" href="javascript:void();"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                                class="bx bx-power-off font-size-16 align-middle mr-1 text-danger"></i>
                            Logout </a>
                        <form id="logout-form" action="https://doctorly.themesbrand.website/logout" method="POST" style="display: none;">
                            <input type="hidden" name="_token" value="YS4Ho2CII2leAV1ZAEbn9G5ktUTnzgvJL0QgFcNE">                    </form>
                    </div>
                </div>
                <div class="dropdown d-inline-block">
                    <button type="button" class="btn header-item noti-icon right-bar-toggle waves-effect ">
                        <i class="bx bx-cog bx-spin"></i>
                    </button>
                </div>
            </div>
        </div>
    </header>
    <div class="topnav">
        <div class="container-fluid">
            <nav class="navbar navbar-light navbar-expand-lg topnav-menu">
                <div class="collapse navbar-collapse" id="topnav-menu-content">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="https://doctorly.themesbrand.website">
                                <i class="bx bx-home-circle mr-2"></i>Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="https://doctorly.themesbrand.website/appointment/create">
                                <i class="bx bx-calendar-plus mr-2"></i>Appointment
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-layout" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="bx bx-user-circle mr-2"></i>Patients <div
                                    class="arrow-down"></div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="topnav-layout">
                                <a href="https://doctorly.themesbrand.website/patient"
                                   class="dropdown-item">List of Patients</a>
                                <a href="https://doctorly.themesbrand.website/patient/create"
                                   class="dropdown-item">Add New Patient</a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="https://doctorly.themesbrand.website/receptionist">
                                <i class="bx bx-user-circle mr-2"></i>Receptionist
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-layout" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="bx bx-notepad mr-2"></i>Prescription<div
                                    class="arrow-down"></div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="topnav-layout">
                                <a href="https://doctorly.themesbrand.website/prescription"
                                   class="dropdown-item">List of Prescriptions</a>
                                <a href="https://doctorly.themesbrand.website/prescription/create"
                                   class="dropdown-item">Create Prescription</a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-layout" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="bx bx-receipt mr-2"></i>Invoices <div class="arrow-down">
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="topnav-layout">
                                <a href="https://doctorly.themesbrand.website/invoice"
                                   class="dropdown-item">List of Invoices</a>
                                <a href="https://doctorly.themesbrand.website/invoice/create"
                                   class="dropdown-item">Create New Invoice</a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="https://doctorly.themesbrand.website/pending-appointment">
                                <i class='bx bx-list-plus mr-2'></i>Appointment List
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">
        <div class="page-content">
            <!-- Start content -->
            <div class="container-fluid">
                <!-- start page title -->
                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-flex align-items-center justify-content-between">
                            <h4 class="mb-0 font-size-18">Create Prescription</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="https://doctorly.themesbrand.website">Dashboard</a></li>
                                    <li class="breadcrumb-item">Prescription</li>
                                    <li class="breadcrumb-item">Create Prescription</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end page title -->
                <!-- end page title -->
                <div class="row">
                    <div class="col-12">
                        <a href="https://doctorly.themesbrand.website/prescription">
                            <button type="button" class="btn btn-primary waves-effect waves-light mb-4">
                                <i
                                    class="bx bx-arrow-back font-size-16 align-middle mr-2"></i>Back to Prescription List
                            </button>
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <blockquote>Prescription Details</blockquote>
                                <form class="outer-repeater" action="https://doctorly.themesbrand.website/prescription" method="post">
                                    <input type="hidden" name="_token" value="YS4Ho2CII2leAV1ZAEbn9G5ktUTnzgvJL0QgFcNE">                            <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label class="control-label">Patient <span
                                                    class="text-danger">*</span></label>
                                            <select
                                                class="form-control select2 sel_patient "
                                                name="patient_id" id="patient">
                                                <option disabled selected>Select Patient</option>
                                                <option value="16" >
                                                    Patient Doctorly</option>
                                                <option value="17" >
                                                    Elinore Goodwin</option>
                                                <option value="18" >
                                                    Dr. Alisa Bruen</option>
                                                <option value="19" >
                                                    Leonor Waelchi V</option>
                                                <option value="20" >
                                                    Nicole Carter</option>
                                                <option value="21" >
                                                    Grace Hirthe</option>
                                                <option value="22" >
                                                    Mercedes Lind</option>
                                                <option value="23" >
                                                    Jordyn Douglas PhD</option>
                                                <option value="24" >
                                                    Schuyler Weber</option>
                                                <option value="25" >
                                                    Dayana Reichel</option>
                                                <option value="26" >
                                                    Dr. Kenya White</option>
                                                <option value="27" >
                                                    Maud Boehm MD</option>
                                                <option value="28" >
                                                    Malvina Brakus</option>
                                                <option value="29" >
                                                    Nettie Beahan</option>
                                                <option value="30" >
                                                    Buddynew Freddy</option>
                                                <option value="47" >
                                                    cutsc carl</option>
                                                <option value="48" >
                                                    aTest Thisis</option>
                                                <option value="49" >
                                                    Farhan Madka</option>
                                                <option value="50" >
                                                    ahmed fahamy</option>
                                                <option value="51" >
                                                    kaushik dhameliya</option>
                                                <option value="53" >
                                                    aaaa aaaa</option>
                                                <option value="54" >
                                                    abdelhak dridijjj</option>
                                                <option value="56" >
                                                    test test</option>
                                                <option value="58" >
                                                    dfgdf gdfgdfg</option>
                                                <option value="59" >
                                                    test test</option>
                                                <option value="60" >
                                                    Melvin Ramos</option>
                                                <option value="61" >
                                                    nassim nassim</option>
                                                <option value="62" >
                                                    Test pacienti</option>
                                                <option value="64" >
                                                    testORL testORL</option>
                                                <option value="65" >
                                                    tarakvitarak news</option>
                                                <option value="66" >
                                                    Rajib Das</option>
                                                <option value="67" >
                                                    llllllll wwwwww</option>
                                                <option value="68" >
                                                    LULU LULU</option>
                                                <option value="69" >
                                                    sojwal patil</option>
                                                <option value="70" >
                                                    mat gu</option>
                                                <option value="71" >
                                                    Hany abdallah</option>
                                                <option value="72" >
                                                    Vrau Burger</option>
                                                <option value="73" >
                                                    Björn Beier</option>
                                                <option value="74" >
                                                    NItin Raje</option>
                                                <option value="75" >
                                                    Mohammed AbdulBasith</option>
                                                <option value="76" >
                                                    Cristhian Carry</option>
                                                <option value="77" >
                                                    Mahmoud Abbas</option>
                                                <option value="78" >
                                                    Olaniyan Kolade</option>
                                                <option value="79" >
                                                    Ivana Battle</option>
                                                <option value="80" >
                                                    Kiran Prajapati</option>
                                                <option value="81" >
                                                    ทดสอบภาษาไทย THAILANGUAGE</option>
                                                <option value="82" >
                                                    Arne Peine</option>
                                                <option value="83" >
                                                    بيب بيبي</option>
                                                <option value="84" >
                                                    Prashant jha</option>
                                                <option value="85" >
                                                    hello last</option>
                                                <option value="86" >
                                                    nik dasd</option>
                                                <option value="87" >
                                                    Olympique Marseille</option>
                                                <option value="88" >
                                                    paras as</option>
                                                <option value="89" >
                                                    Test Test</option>
                                                <option value="90" >
                                                    Adeoye Adeoye</option>
                                                <option value="91" >
                                                    Putin Russia</option>
                                                <option value="94" >
                                                    Testo Testi</option>
                                                <option value="95" >
                                                    calvin calvin</option>
                                                <option value="96" >
                                                    sukar ali</option>
                                                <option value="98" >
                                                    Tpatient Tpatient</option>
                                                <option value="99" >
                                                    rag test</option>
                                                <option value="100" >
                                                    new patient</option>
                                                <option value="101" >
                                                    juve forza</option>
                                                <option value="102" >
                                                    g g</option>
                                                <option value="103" >
                                                    test test</option>
                                                <option value="104" >
                                                    Helle Jorgensen</option>
                                                <option value="105" >
                                                    RK Kumar</option>
                                                <option value="106" >
                                                    Anwar Ali</option>
                                                <option value="107" >
                                                    Abhishek Polawala</option>
                                                <option value="108" >
                                                    MohFebri NurulQorik</option>
                                                <option value="110" >
                                                    ssssssssssss ssssssssssss</option>
                                                <option value="111" >
                                                    Naveen reddy</option>
                                                <option value="113" >
                                                    safer awetqe</option>
                                                <option value="114" >
                                                    test Test</option>
                                                <option value="115" >
                                                    demo user</option>
                                                <option value="116" >
                                                    Mehmet ASLAN</option>
                                                <option value="118" >
                                                    Claudio Espinoza</option>
                                                <option value="119" >
                                                    test tedt</option>
                                                <option value="120" >
                                                    محمد ابوطالبی</option>
                                                <option value="121" >
                                                    juan ooo</option>
                                                <option value="122" >
                                                    Test RrPp</option>
                                                <option value="123" >
                                                    Shoaib BinHabib</option>
                                                <option value="124" >
                                                    Emi Jensen</option>
                                                <option value="126" >
                                                    dfsdfsd sdfsdf</option>
                                                <option value="127" >
                                                    Baraa ddd</option>
                                                <option value="128" >
                                                    Skote Skote</option>
                                                <option value="129" >
                                                    Skote Skote</option>
                                                <option value="130" >
                                                    Testuser Test</option>
                                                <option value="131" >
                                                    test test</option>
                                                <option value="132" >
                                                    Laouini LAOUINI</option>
                                                <option value="133" >
                                                    sumit bajaj</option>
                                                <option value="134" >
                                                    test test</option>
                                                <option value="136" >
                                                    Fahmi Syaban</option>
                                                <option value="137" >
                                                    Margie Snovel</option>
                                                <option value="138" >
                                                    prenom nom</option>
                                                <option value="141" >
                                                    Rishika Sharma</option>
                                                <option value="143" >
                                                    William Calisaya</option>
                                                <option value="144" >
                                                    sdfsdfsdf Adsfsdfd</option>
                                                <option value="145" >
                                                    Alisher Rustamov</option>
                                                <option value="147" >
                                                    bfjfsdj safbfsb</option>
                                                <option value="149" >
                                                    Bryan Palacios</option>
                                                <option value="152" >
                                                    Test RP</option>
                                                <option value="153" >
                                                    Sumant Behera</option>
                                                <option value="154" >
                                                    haggai ham</option>
                                                <option value="155" >
                                                    SAJIB MALLIK</option>
                                                <option value="157" >
                                                    cristofer vargas</option>
                                                <option value="159" >
                                                    dds dsds</option>
                                                <option value="160" >
                                                    Putri Ganda</option>
                                                <option value="161" >
                                                    Hamza Sellami</option>
                                                <option value="163" >
                                                    tewst fdsaf</option>
                                                <option value="164" >
                                                    tewst fdsaf</option>
                                                <option value="166" >
                                                    Asim Mughal</option>
                                                <option value="167" >
                                                    Mohamed Ahmed</option>
                                                <option value="169" >
                                                    Claudio Hernandez</option>
                                                <option value="170" >
                                                    HORUS Hassan</option>
                                                <option value="171" >
                                                    Mike Velez</option>
                                                <option value="172" >
                                                    كاظم علي</option>
                                                <option value="173" >
                                                    Muhnaah Exidus</option>
                                                <option value="174" >
                                                    Regina Test</option>
                                                <option value="176" >
                                                    مينا kamal</option>
                                                <option value="178" >
                                                    Maria Gutierrez</option>
                                                <option value="179" >
                                                    anand Sathyanathan</option>
                                                <option value="180" >
                                                    karim abdalwhab</option>
                                                <option value="185" >
                                                    kawsar test</option>
                                                <option value="188" >
                                                    Mahesh Israel</option>
                                                <option value="189" >
                                                    testuser test</option>
                                                <option value="190" >
                                                    test LL</option>
                                                <option value="191" >
                                                    ramsdsdsd ari</option>
                                                <option value="193" >
                                                    werwe sdrg</option>
                                                <option value="194" >
                                                    Stephen Bondzie</option>
                                                <option value="195" >
                                                    Demo Test</option>
                                                <option value="196" >
                                                    رؤلاؤرلا محمود</option>
                                                <option value="198" >
                                                    mark kornienko</option>
                                                <option value="199" >
                                                    MAHESH Devi</option>
                                                <option value="203" >
                                                    mohamed elsherbiny</option>
                                                <option value="205" >
                                                    Vaibhav Choudhary</option>
                                                <option value="207" >
                                                    israel mukeba</option>
                                                <option value="208" >
                                                    Mahesh Sain</option>
                                                <option value="209" >
                                                    Brock Dennis</option>
                                                <option value="210" >
                                                    cgc ggvcc</option>
                                                <option value="212" >
                                                    Arga Sofyan</option>
                                                <option value="213" >
                                                    adasdad asdasdasd</option>
                                                <option value="215" >
                                                    test test</option>
                                                <option value="218" >
                                                    ghgfhfgh ghfghfh</option>
                                                <option value="219" >
                                                    Sunny gulati</option>
                                                <option value="222" >
                                                    Paris Patient</option>
                                                <option value="223" >
                                                    Nesan nn</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label class="control-label">Appointment <span
                                                    class="text-danger">*</span></label>
                                            <select
                                                class="form-control select2 sel_appointment "
                                                name="appointment_id" id="appointment">
                                                <option disabled selected>Select Appointment</option>
                                            </select>
                                        </div>
                                        <input type="hidden" name="created_by" value="2">
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label class="control-label">Symptoms <span
                                                    class="text-danger">*</span></label>
                                            <textarea class="form-control " name="symptoms"
                                                      id="symptoms" placeholder="Add Symptoms"
                                                      rows="3"></textarea>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label class="control-label">Diagnosis <span
                                                    class="text-danger">*</span></label>
                                            <textarea class="form-control " name="diagnosis"
                                                      id="diagnosis" placeholder="Add Diagnosis"
                                                      rows="3"></textarea>
                                        </div>
                                    </div>
                                    <blockquote>Medication &amp; Test Reports Details</blockquote>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class='repeater mb-4'>
                                                <div data-repeater-list="medicines" class="form-group">
                                                    <label>Medicines <span class="text-danger">*</span></label>
                                                    <div data-repeater-item class="mb-3 row">
                                                        <div class="col-md-5 col-6">
                                                            <input type="text" name="medicine" class="form-control"
                                                                   placeholder="Medicine Name" />
                                                        </div>
                                                        <div class="col-md-5 col-6">
                                                    <textarea type="text" name="notes" class="form-control"
                                                              placeholder="Notes..."></textarea>
                                                        </div>
                                                        <div class="col-md-2 col-4">
                                                            <input data-repeater-delete type="button"
                                                                   class="fcbtn btn btn-outline btn-danger btn-1d btn-sm inner"
                                                                   value="X" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <input data-repeater-create type="button" class="btn btn-primary"
                                                       value="Add Medicine" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class='repeater mb-4'>
                                                <div data-repeater-list="test_reports" class="form-group">
                                                    <label>Test Reports </label>
                                                    <div data-repeater-item class="mb-3 row">
                                                        <div class="col-md-5 col-6">
                                                            <input type="text" name="test_report" class="form-control"
                                                                   placeholder="Test Report Name" />
                                                        </div>
                                                        <div class="col-md-5 col-6">
                                                    <textarea type="text" name="notes" class="form-control"
                                                              placeholder="Notes..."></textarea>
                                                        </div>
                                                        <div class="col-md-2 col-4">
                                                            <input data-repeater-delete type="button"
                                                                   class="fcbtn btn btn-outline btn-danger btn-1d btn-sm inner"
                                                                   value="X" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <input data-repeater-create type="button" class="btn btn-primary"
                                                       value="Add Test Report" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-primary">
                                                Create Prescription
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->
            </div> <!-- content -->
        </div>
        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        2022 © Doctorly
                    </div>
                    <div class="col-sm-6">
                        <div class="text-sm-right d-none d-sm-block">
                            Design &amp; Develop by Themesbrand
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <!-- ============================================================== -->
    <!-- End Right content here -->
    <!-- ============================================================== -->
</div>
<!-- END wrapper -->

<!-- Right Sidebar -->
<!-- Right Sidebar -->
<div class="right-bar">
    <div data-simplebar class="h-100">
        <div class="rightbar-title px-3 py-4">
            <a href="javascript:void(0);" class="right-bar-toggle float-right">
                <i class="mdi mdi-close noti-icon"></i>
            </a>
            <h5 class="m-0">Settings</h5>
        </div>
        <!-- Settings -->
        <hr class="mt-0" />
        <h6 class="text-center">Choose Layouts</h6>
        <div class="p-4">
            <div class="mb-2">
                <img src="https://doctorly.themesbrand.website/assets/images/layouts/layout-1.jpg" class="img-fluid img-thumbnail" alt="">
            </div>
            <div class="custom-control custom-switch mb-3">
                <input type="checkbox" class="custom-control-input theme-choice" id="light-mode-switch"
                       checked />
                <label class="custom-control-label" for="light-mode-switch">Light Mode</label>
            </div>
            <div class="mb-2">
                <img src="https://doctorly.themesbrand.website/assets/images/layouts/layout-2.jpg" class="img-fluid img-thumbnail" alt="">
            </div>
            <div class="custom-control custom-switch mb-3">
                <input type="checkbox" class="custom-control-input theme-choice" id="dark-mode-switch"
                       data-bsStyle="https://doctorly.themesbrand.website/assets/css/bootstrap-dark.min.css"
                       data-appStyle="https://doctorly.themesbrand.website/assets/css/app-dark.min.css" />
                <label class="custom-control-label" for="dark-mode-switch">Dark Mode</label>
            </div>
            <div class="mb-2">
                <img src="https://doctorly.themesbrand.website/assets/images/layouts/layout-3.jpg" class="img-fluid img-thumbnail" alt="">
            </div>
            <div class="custom-control custom-switch mb-5">
                <input type="checkbox" class="custom-control-input theme-choice" id="rtl-mode-switch"
                       data-appStyle="https://doctorly.themesbrand.website/assets/css/app-rtl.min.css" />
                <label class="custom-control-label" for="rtl-mode-switch">RTL Mode</label>
            </div>
            <a href="javascript::void(0);" class="btn btn-primary btn-block mt-3" target="_blank"><i
                    class="mdi mdi-cart mr-1"></i> Purchase Now</a>
        </div>
    </div> <!-- end slim-scroll-menu-->
</div>
<!-- /Right-bar -->
<!-- END Right Sidebar -->

<!-- JAVASCRIPT -->
<script src="https://doctorly.themesbrand.website/assets/libs/jquery/jquery.min.js"></script>
<script src="https://doctorly.themesbrand.website/assets/libs/bootstrap/bootstrap.min.js"></script>
<script src="https://doctorly.themesbrand.website/assets/libs/metismenu/metismenu.min.js"></script>
<script src="https://doctorly.themesbrand.website/assets/libs/simplebar/simplebar.min.js"></script>
<script src="https://doctorly.themesbrand.website/assets/libs/node-waves/node-waves.min.js"></script>
<script src="https://doctorly.themesbrand.website/assets/libs/toastr/toastr.min.js"></script>

<script src="https://doctorly.themesbrand.website/assets/libs/select2/select2.min.js"></script>
<!-- form mask -->
<script src="https://doctorly.themesbrand.website/assets/libs/jquery-repeater/jquery-repeater.min.js"></script>
<!-- form init -->
<script src="https://doctorly.themesbrand.website/assets/js/pages/form-repeater.int.js"></script>
<script src="https://doctorly.themesbrand.website/assets/js/pages/form-advanced.init.js"></script>
<script src="https://doctorly.themesbrand.website/assets/js/pages/notification.init.js"></script>
<script>
    $('.sel_patient').on('change', function(e) {
        e.preventDefault();
        var patientId = $(this).val();
        var token = $("input[name='_token']").val();
        $.ajax({
            type: "POST",
            url: "https://doctorly.themesbrand.website/patient-by-appointment",
            data: {
                patient_id: patientId,
                _token: token,
            },
            success: function(res) {
                $('.sel_appointment').html('');
                $('.sel_appointment').html(res.options);
            },
            error: function(res) {
                console.log(res);
            }
        });
    });
</script>
<!-- App js -->
<script src="https://doctorly.themesbrand.website/assets/js/app.min.js"></script>
<script>
    function notifyCount(){
        var load_count = $('.badge-pill').html();
        var token = $("input[name='_token']").val();
        $.ajax({
            type: "get",
            url: "/notification-count",
            data:{
                _token: token,
            },
            success: function (data) {
                $('.badge-pill').html(data);
                if(load_count < data){ notificationShow(); } }, error:function (data){ console.log(data); } }); }
    setInterval(function() { notifyCount(); }, 10000);                             function notificationShow(){
        var token = $("input[name='_token']").val();
        $.ajax({
            type: "POST",
            url: "/top-notification",
            data:{
                _token: token,
            },
            success: function (data) {
                $('.notification-list-scroll').html(data.options);
            },
            error:function (data){
                console.log(data);
            }
        });
    }
    setInterval(function() {
        notificationShow();
    }, 5000);
</script>
</body>

</html>
