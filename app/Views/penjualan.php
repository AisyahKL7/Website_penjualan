<?php $this->extend('template') ?>

<?php $this->section('content') ?>
<div class="card">
    <div class="card-header">
        <div class="row align-items-center justify-content-between">
            <div class="col-lg-2">
                <h1 class="card-title">Data Penjualan</h1>
                <label id="pesanError" class="badge badge-danger"></label>
            </div>
            <div class="col-lg-2 d-grid gap-2">
                <button type="button" class="btn btn-success btn-sm btn-block" id="btnshowmodal">Import Excel</button>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive" id="tempatTabel">
            <table id="penjualan-table" class="display table table-striped table-hover">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>ID TOKO</th>
                        <th>ALAMAT TOKO</th>
                        <th>NAMA PRODUK</th>
                        <th>BARCODE</th>
                        <th>KATEGORI</th>
                        <th>TANGGAL</th>
                        <th>JUMLAH TERJUAL</th>
                        <th>ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if(isset($data) && !empty($data)){
                            $num = 1;
                            foreach($data as $row){
                        ?>
                        <tr>
                            <td><?= $num++; ?></td>
                            <td><?= $row['id_toko']; ?></td>
                            <td><?= $row['alamat']; ?></td>
                            <td><?= $row['nama_produk']; ?></td>
                            <td><?= $row['barcode'] ? $row['barcode'] : '-'; ?></td>
                            <td><?= $row['kategori']; ?></td>
                            <td><?= $row['tanggal'] ? date('d F Y', strtotime($row['tanggal'])) : '-'; ?></td>
                            <td><?= $row['terjual']; ?></td>
                            <td>
                                <button class="btn btn-primary btn-xs" onclick="showmodaleditpenjulan(<?= $row['id'] ?>)">Edit</button>
                                <button class="btn btn-danger btn-xs" onclick="showdeleteModel('<?= $row['id'] ?>')">Delete</button>
                            </td>
                        </tr>
                        <?php
                            }

                        }else{
                    ?>
                    <tr>
                        <td colspan="8" style="text-align:center">No Available data.</td>
                    </tr>
                    <?php
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="uploadFileModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Upload File Excel</h5>
            </div>
            <div class="modal-body p-0">
                <div class="form" style="margin:30px">
                    <form method="post" action="/penjualan/processExcel" enctype="multipart/form-data">
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <input type="file" class="form-control" required id="fileexcel" name="fileexcel">
                            </div>
                        </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-12 text-center">
                        <button type="submit" class="btn btn-success">Upload</button>
                    </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="idTransaksi">
                <input type="hidden" id="statusTransaksi">
                <button type="button" class="btn btn-warning" onclick="tutupModalRincian()">Tutup</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Data Penjualan</h5>
            </div>
            <div class="modal-body p-0">
                <div class="form" style="margin:30px">
                    <form id="form_edit" method="post" enctype="multipart/form-data">
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <label for="id_toko">ID TOKO</label>
                                <input type="hidden" class="form-control" name="idpenjualan" id="idpenjualan" placeholder="ID TOKO">
                                <input type="text" class="form-control" name="id_toko" id="id_toko" placeholder="ID TOKO">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <label for="alamat">ALAMAT</label>
                                <textarea class="form-control" name="alamat" id="alamat" cols="30" rows="10" placeholder="ALAMAT TOKO"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <label for="nama_produk">NAMA PRODUK</label>
                                <input type="text" class="form-control" name="nama_produk" id="nama_produk" placeholder="NAMA PRODUK">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <label for="barcode">BARCODE</label>
                                <input type="text" class="form-control" name="barcode" id="barcode" placeholder="BARCODE">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <label for="kategori">KATEGORI</label>
                                <input type="text" class="form-control" name="kategori" id="kategori" placeholder="KATEGORI">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <label for="tanggal">TANGGAL</label>
                                <input type="date" class="form-control" name="tanggal" id="tanggal" placeholder="TANGGAL">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <label for="terjual">TERJUAL</label>
                                <input type="number" min="1" class="form-control" name="terjual" id="terjual" placeholder="TERJUAL">
                            </div>
                        </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" onclick="tutupeditModal()">Batal</button>
                <button type="submit" class="btn btn-success">Simpan</button>
                    </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Apakah anda ingin menghapus data ini?</h5>
            </div>
            <div class="modal-footer">
                <form id="formdelete">
                <button type="button" class="btn btn-warning" onclick="tutupdeleteModal()">Batal</button>
                <button type="submit" class="btn btn-success">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php $this->endSection() ?>

