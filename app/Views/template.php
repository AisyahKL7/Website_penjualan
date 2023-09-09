<!DOCTYPE html>
<html lang="en">
<?php $url = current_url(true); ?>

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Penjualan | <?= $url->getSegment(2) ?> </title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="vendors/feather/feather.css">
    <link rel="stylesheet" href="vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="vendors/typicons/typicons.css">
    <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="css/vertical-layout-light/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="images/favicon.png" />
</head>

<body>
    <div class="container-scroller">
        <!-- partial:../../partials/_navbar.html -->
        <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex align-items-top flex-row">
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
                <div class="me-3">
                    <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-bs-toggle="minimize">
                        <span class="icon-menu"></span>
                    </button>
                </div>
                <div>
                    <a class="navbar-brand brand-logo" href="/">
                        <img src="images/logo.svg" alt="logo" />
                    </a>
                    <a class="navbar-brand brand-logo-mini" href="/">
                        <img src="images/logo-mini.svg" alt="logo" />
                    </a>
                </div>
            </div>
            <div class="navbar-menu-wrapper d-flex align-items-top">
                <ul class="navbar-nav">
                    <li class="nav-item font-weight-semibold d-none d-lg-block ms-0">
                        <h1 class="welcome-text">Hallo, <span class="text-black fw-bold"><?= session()->get("nama") ?></span></h1>
                        <h3 class="welcome-sub-text"> Semoga hari ini lancar ya :) </h3>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a type="button" class="btn btn-social-icon-text btn-dribbble" href="dashboard/logout"><i class="mdi mdi-account-check"></i>Log out</a>
                    </li>
                </ul>
                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-bs-toggle="offcanvas">
                    <span class="mdi mdi-menu"></span>
                </button>
            </div>
        </nav>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial -->
            <!-- partial:../../partials/_sidebar.html -->
            <nav class="sidebar sidebar-offcanvas" id="sidebar">
                <ul class="nav">
                    <li class="nav-item <?php if ($url->getSegment(3) == "test") {
                                            echo "active";
                                        } ?>">
                    </li>
                    <li class="nav-item <?php if ($url->getSegment(3) == "laporan") {
                                            echo "active";
                                        } ?>">
                        <a class="nav-link" href="penjualan">
                            <i class="menu-icon mdi mdi-book-open-page-variant"></i>
                            <span class="menu-title">Data Penjualan</span>
                        </a>
                    </li>
                    <li class="nav-item nav-category">Data Master</li>
                    <?php if (session()->get("rule") == 1) : ?>
                        <li class="nav-item <?php if ($url->getSegment(3) == "user") {
                                                echo "active";
                                            } ?>">
                            <a class="nav-link" href="user">
                                <i class="menu-icon mdi mdi-account-multiple"></i>
                                <span class="menu-title">User</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <?php $this->renderSection('content'); ?>
                </div>
                <!-- content-wrapper ends -->
                <!-- partial:../../partials/_footer.html -->
                <footer class="footer">
                    <div class="d-sm-flex justify-content-center justify-content-sm-between">
                        <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Premium <a href="https://www.bootstrapdash.com/" target="_blank">Bootstrap admin template</a> from BootstrapDash.</span>
                        <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Copyright © 2021. All rights reserved.</span>
                    </div>
                </footer>
            </div>
            <!-- partial -->
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- endinject -->
    <!-- container-scroller -->
    <!-- plugins:js -->
    <!-- Plugin js for this page -->
    
    <script src="js/jquery/jquery.min.js"></script>
    <script src="vendors/js/vendor.bundle.base.js"></script>
    <script src="vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="js/off-canvas.js"></script>
    <script src="js/hoverable-collapse.js"></script>
    <script src="js/settings.js"></script>
    <script src="js/todolist.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page-->
    <!-- End custom js for this page-->
    <script>
    $('#penjualan-table').DataTable();

    $('#btnshowmodal').on('click', function(){
        $('#uploadFileModal').modal('show');
    });

    function tutupModalRincian() {
        $("#uploadFileModal").modal("hide")
    }

    function tutupeditModal() {
        $("#editModal").modal("hide")
    }

    function tutupdeleteModal() {
        $("#deleteModal").modal("hide")
    }

    function showmodaleditpenjulan(id){
        $.ajax({
            url: '<?= base_url() ?>/penjualanbyid/'+id,
            method: 'get',
            data: null,
            dataType: 'json',
            success: function(data) {
                if(data.err == false){
                    let det = data.data;

                    const d = new Date(det.tanggal);
                    var day = ("0" + d.getDate()).slice(-2);
                    var month = ("0" + (d.getMonth() + 1)).slice(-2);
                    var tanggal = d.getFullYear()+"-"+(month)+"-"+(day); 

                    $('#editModal').modal('show');
                    $('#form_edit').attr('action','penjualan/updatepenjualan/'+id);
                    $('#idpenjualan').val(det.id);
                    $('#id_toko').val(det.id_toko);
                    $('#alamat').val(det.alamat);
                    $('#nama_produk').val(det.nama_produk);
                    $('#barcode').val(det.barcode);
                    $('#kategori').val(det.kategori);
                    $('#tanggal').val(tanggal);
                    $('#terjual').val(det.terjual);
                }
            }
        });
    }

    function showdeleteModel(id){
        $('#deleteModal').modal('show');
        $('#formdelete').attr('action','/deletepenjualan/'+id);
    }

</script>
</body>

</html>