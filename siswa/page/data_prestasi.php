<div class="col-md-12">
    
    <div class="box">
        <div class="box-header">
            <a href="#" class="btn btn-primary btn-sm pull-right btn-tambah">Tambah</a>
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="data-prestasi" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Prestasi</th>
                            <th>Lihat Sertifikat / Bukti Prestasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <!-- modal tambah edit -->
    <div class="modal fade modal-center" id="modal-prestasi" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="form-prestasi" method="POST" enctype="multipart/form-data">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>    
                        <h4 class="modal-title" id="modal-title"></h4>
                    </div>

                    <div class="modal-body">
                        <input type="hidden" name="token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>" readonly>

                        <div class="form-group">
                            <label for="nama_prestasi">Nama Prestasi</label>
                            <input type="text" class="form-control" id="nama_prestasi" name="nama_prestasi" placeholder="Masukkan nama prestasi" required>
                        </div>

                        <div class="form-group">
                            <label for="file_prestasi">File Bukti Prestasi</label>
                            <input type="file" class="form-control" id="file_prestasi" name="file_prestasi" accept=".pdf">
                            <small><i>Bukti prestasi haruslah berupa file pdf</i></small>
                            <br>
                            <small><i class="catatan-edit"></i></small>
                        </div>
                        
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Simpan</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>                            
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script>
        $(document).ready(function () {
            const token = $('meta[name="csrf-token"]').attr('content');
            const table = $('#data-prestasi').DataTable({
                ajax: {
                    url: 'prestasi?act=' + encodeURIComponent('<?= encrypt('read') ?>'),
                    type: "POST",
                    data: { token:token },
                },
                processing: true,
                serverSide: false,
                columns: [
                    { data: 'no' },
                    { data: 'nama' },
                    {
                        data: 'file',
                        render: function (data) {
                            return `<a href="${data}" target="_blank" class="btn-pdf-images" data-file="../${data}" data-ext="pdf" data-title="File Bukti Prestasi" >Lihat File Sertifikat</a>`;
                        }
                    },
                    {
                        data: 'id',
                        render: function (id) {
                            return `
                                <button class="btn btn-warning btn-sm btn-edit" data-id="${id}" data-token="${token}"><i class="fa fa-edit"></i> Edit</button>
                                <button class="btn btn-danger btn-sm btn-delete" data-id="${id}" data-token="${token}"><i class="fa fa-trash"></i> Hapus</button>
                            `;
                        }
                    }
                ]
            });

            $('.btn-tambah').on('click', function () {
                $('#modal-title').text('Tambah Prestasi');
                $('#form-prestasi')[0].reset();
                $('.catatan-edit').text('');
                $('#form-prestasi').attr('data-action', '<?= encrypt('tambah') ?>');
                $('#file_prestasi').attr('required', true);
                $('#modal-prestasi').modal('show');
            });

            $('#data-prestasi').on('click', '.btn-edit', function () {
                const id = $(this).data('id');
                const token = $(this).data('token');
                $.ajax({
                    url: 'prestasi?act=' + encodeURIComponent('<?= encrypt('edit') ?>'),
                    method: 'POST',
                    data: { token:token, id:id },
                    dataType: 'json',
                    success: function (resp) {
                        if (!resp.status){
                            Swal.fire({
                                title: "Gagal",
                                text: resp.message,
                                icon: "error"
                            });
                        }else{
                            $('#nama_prestasi').val(resp.data.nama);
                            $('#form-prestasi').attr('data-id', resp.data.id).attr('data-action', '<?= encrypt('ubah') ?>');
                            $('#modal-title').text('Ubah Prestasi');
                            $('.catatan-edit').text('Kosongkan jika tidak perlu diubah');
                            $('#file_prestasi').removeAttr('required');
                            $('#modal-prestasi').modal('show');
                        }
                    }
                });
            });

            $('#data-prestasi').on('click', '.btn-delete', function () {
                const id = $(this).data('id');
                const token = $(this).data('token');
                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    text: "Data yang dihapus tidak bisa dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: 'prestasi?act=' + encodeURIComponent('<?= encrypt('hapus') ?>'),
                            method: 'POST',
                            data: { token:token, id:id },
                            dataType: 'json',
                            success: function (resp) {
                                if (!resp.status){
                                    Swal.fire({
                                        title: "Gagal",
                                        text: resp.message,
                                        icon: "error"
                                    });
                                }else{
                                    Swal.fire({
                                        title: "Sukses",
                                        text: resp.message,
                                        icon: "success"
                                    });
                                    table.ajax.reload();
                                }
                            }
                        });
                    }
                });
            });
            
            // Validasi jQuery Validator
            $.validator.setDefaults({
                highlight: function (element) {
                    $(element).addClass('error');
                },
                unhighlight: function (element) {
                    $(element).removeClass('error');
                }
            });

            $.validator.addMethod("maxfilesize", function(value, element, param) {
                if (element.files.length === 0) return true;
                return element.files[0].size <= param;
            }, "Ukuran file terlalu besar.");

            $.validator.addMethod("extension", function(value, element, param) {
                const fileName = element.value;
                const ext = fileName.split('.').pop().toLowerCase();
                return this.optional(element) || param.split('|').indexOf(ext) !== -1;
            }, "Format file tidak valid. Harus berupa PDF.");

            
            // Inisialisasi validasi form
            const validator = $("#form-prestasi").validate({
                rules: {
                    nama_prestasi : { 
                        required: true,
                    },
                    file_prestasi : { 
                        required: function () {
                            return $('#form-prestasi').attr('data-action') === '<?= encrypt("tambah") ?>';
                        },
                        extension: "pdf",
                        maxfilesize: 2097152 // 2 MB dalam byte
                    },
                },
                messages: {
                    nama_prestasi : "Nama prestasi wajib diisi.",
                    file_prestasi: {
                        required: "File bukti prestasi wajib diisi.",
                        extension: "Hanya file PDF yang diperbolehkan.",
                        maxfilesize: "Ukuran file maksimal 2 MB."
                    },
                },
                errorPlacement: function (error, element) {
                    error.insertAfter(element);
                    element.addClass('is-invalid');
                },
                success: function (label, element) {
                    $(element).removeClass('is-invalid');
                },
                submitHandler: function (form) {
                    var formData = new FormData($('#form-prestasi')[0]);
                    const action = $(form).attr('data-action');
                    const id = $(form).attr('data-id') || '';
                    formData.append('id', id);
                    $.ajax({
                        url: 'prestasi?act=' + encodeURIComponent(action),
                        method: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        dataType: 'json',
                        success: function (resp) {
                            if (!resp.status){
                                Swal.fire({
                                    title: "Gagal",
                                    text: resp.message,
                                    icon: "error"
                                });
                            }else{
                                $('#modal-prestasi').modal('hide');
                                table.ajax.reload();
                                Swal.fire({
                                    title: "Sukses",
                                    text: resp.message,
                                    icon: "success"
                                });
                                $('#form-prestasi')[0].reset();
                            }
                        }
                    });

                    return false;
                }
            });

        });
    </script>
</div>
