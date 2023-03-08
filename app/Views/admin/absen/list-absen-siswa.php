<div class="card-body">
    <div class="row">
        <div class="col-auto me-auto">
            <div class="pt-3 pl-3">
                <h4><b>Absen Siswa</b></h4>
                <p>Daftar siswa muncul disini</p>
            </div>
        </div>
        <div class="col">
            <a href="#" class="btn btn-primary pl-3 mr-3 mt-3" onclick="kelas = onDateChange()" data-toggle="tab">
                <i class="material-icons mr-2">refresh</i> Refresh
            </a>
        </div>
        <div class="col-auto">
            <div class="px-4">
                <h3 class="text-end">
                    <b class="text-primary"><?= $kelas; ?></b>
                </h3>
            </div>
        </div>
    </div>

    <div id="dataSiswa" class="card-body table-responsive pb-5">
        <?php if (!empty($data)) : ?>
            <table class="table table-hover">
                <thead class="text-primary">
                    <th>No.</th>
                    <th>NIS</th>
                    <th>Nama Siswa</th>
                    <th>Kehadiran</th>
                    <th>Jam masuk</th>
                    <th>Jam pulang</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    <?php foreach ($data as $value) : ?>
                        <?php
                        $id_kehadiran = intval($value['id_kehadiran'] ?? ($lewat ? 5 : 4));
                        $kehadiran = kehadiran($id_kehadiran);
                        ?>
                        <tr>
                            <td><?= $no; ?></td>
                            <td><?= $value['nis']; ?></td>
                            <td><b><?= $value['nama_siswa']; ?></b></td>
                            <td>
                                <p class="p-2 w-100 btn btn-<?= $kehadiran['color']; ?> text-center">
                                    <b><?= $kehadiran['text']; ?></b>
                                </p>
                            </td>
                            <td><?= $value['jam_masuk'] ?? '-'; ?></td>
                            <td><?= $value['jam_keluar'] ?? '-'; ?></td>
                            <td><?= $value['keterangan'] ?? '-'; ?></td>
                            <td>
                                <?php if (!$lewat) : ?>
                                    <div class="dropstart">
                                        <button type="button" class="btn btn-info p-2 dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" id="<?= $value['nis']; ?>">
                                            <i class="material-icons">edit</i>
                                            Edit
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="<?= $value['nis']; ?>">
                                            <form id="formUbah<?= $value['id_siswa']; ?>">
                                                <div class="row">
                                                    <div class="col">
                                                        <h5 class="dropdown-header">Ubah kehadiran</h5>
                                                        <input type="hidden" name="id_siswa" value="<?= $value['id_siswa']; ?>">
                                                        <input type="hidden" name="id_kelas" value="<?= $value['id_kelas']; ?>">
                                                        <?php foreach ($listKehadiran as $value2) : ?>
                                                            <div class="px-3">
                                                                <div class="form-control">
                                                                    <?php $color = kehadiran($value2['id_kehadiran'])['color'] ?>
                                                                    <?php if ($value2['id_kehadiran'] == $id_kehadiran) : ?>
                                                                        <input type="radio" name="id_kehadiran" id="<?= $value2['id_kehadiran']; ?>" value="<?= $value2['id_kehadiran']; ?>" checked>
                                                                        <label class="form-check-label text-<?= $color; ?>" for="<?= $value2['id_kehadiran']; ?>">
                                                                            <?= $value2['kehadiran']; ?>
                                                                        </label>
                                                                    <?php elseif ($value2['id_kehadiran'] == 1) : ?>
                                                                        <input type="radio" name="id_kehadiran" id="<?= $value2['id_kehadiran']; ?>" value="<?= $value2['id_kehadiran']; ?>">
                                                                        <label class="form-check-label text-<?= $color; ?>" for="<?= $value2['id_kehadiran']; ?>">
                                                                            <?= $value2['kehadiran']; ?>
                                                                        </label>
                                                                    <?php else : ?>
                                                                        <input type="radio" name="id_kehadiran" id="<?= $value2['id_kehadiran']; ?>" value="<?= $value2['id_kehadiran']; ?>">
                                                                        <label class="form-check-label text-<?= $color; ?>" for="<?= $value2['id_kehadiran']; ?>">
                                                                            <?= $value2['kehadiran']; ?>
                                                                        </label>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>
                                                        <?php endforeach; ?>
                                                    </div>
                                                    <div class="col">
                                                        <h5 class="dropdown-header pb-0 pl-0">Keterangan</h5>
                                                        <div class="pr-3 py-3">
                                                            <textarea name="keterangan"><?= trim($value['keterangan']); ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                            <div class="p-3">
                                                <button id="tombolUbah<?= $value['id_siswa']; ?>" class="btn btn-success w-100">Ubah</button>
                                            </div>
                                            <script>
                                                $('#tombolUbah' + <?= $value['id_siswa']; ?>).click(function(e) {
                                                    ubahKehadiran(<?= $value['id_siswa']; ?>);
                                                });
                                            </script>
                                        </div>
                                    </div>
                                <?php else : ?>
                                    <button class="btn btn-disabled p-2">No Action</button>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php $no++;
                    endforeach ?>
                </tbody>
            </table>
        <?php
        else :
        ?>
            <div class="row">
                <div class="col">
                    <h4 class="text-center text-danger">Data tidak ditemukan</h4>
                </div>
            </div>
        <?php
        endif; ?>
    </div>
</div>

<?php
function kehadiran($kehadiran): array
{
    $text = '';
    $color = '';
    switch ($kehadiran) {
        case 1:
            $color = 'success';
            $text = 'Hadir';
            break;
        case 2:
            $color = 'warning';
            $text = 'Sakit';
            break;
        case 3:
            $color = 'info';
            $text = 'Izin';
            break;
        case 4:
            $color = 'danger';
            $text = 'Tanpa keterangan';
            break;
        case 5:
        default:
            $color = 'disabled';
            $text = 'Belum tersedia';
            break;
    }

    return ['color' => $color, 'text' => $text];
}
?>