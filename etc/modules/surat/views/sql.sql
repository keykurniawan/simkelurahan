rumahsakit
depan
SELECT a.*, b.* FROM permintaan_andonnikah a, data_penduduk b WHERE a.id_kelurahan = $id_kelurahan AND a.nik = b.nik LIMIT $offset , $dataPerPage

rubah
SELECT a.*, b.*, c.* FROM permintaan_andonnikah a, data_penduduk b, pejabat_kelurahan c WHERE  a.nik = b.nik AND a.id_pejabat = c.id_pejabat AND a.id_permintaan_andonnikah = $id_permintaan_andonnikah

reporting
SELECT a . * , b . * , c . * , d . * 
FROM permintaan_andonnikah a, data_penduduk b, pejabat_kelurahan c, kelurahan d
WHERE a.nik = b.nik
AND a.id_pejabat = c.id_pejabat
AND a.id_kelurahan = d.id_kelurahan
AND a.id_kelurahan=? && a.id_permintaan_andonnikah=?

