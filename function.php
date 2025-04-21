<?php

use LDAP\Result;
include 'conn.php';

function insertdata($nama_barang, $katagori, $jumlah, $harga, $tanggal, $conn) {
    $stmt = $conn->prepare("INSERT INTO tabel_barang (nama_barang, katagori, jumlah, harga, tanggal) VALUES (?, ?, ?, ?, ?)");

    if ($stmt) {
        $stmt->bind_param("sssss", $nama_barang, $katagori, $jumlah, $harga, $tanggal);
        
        if ($stmt->execute()) {
            $stmt->close();
            return "Data berhasil disimpan ke database.";
        } else {
            $error = "Error saat eksekusi: " . $stmt->error;
            $stmt->close();
            return $error;
        }
    } else {
        return "Error saat prepare statement: " . $conn->error;
    }
}


// fungsi ambil id dari index.php
function ambil_Id($conn, $id) {
    $sql = "SELECT * FROM tabel_barang WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        return mysqli_fetch_array($result);
    } else {
        return false;
    }
}

// fungsi update data 


// fungsi hapus data 
function update_barang($conn, $id, $nama_barang, $katagori, $jumlah, $harga, $tanggal) {
    $sql = "UPDATE tabel_barang 
            SET nama_barang = '$nama_barang',
                katagori = '$katagori',
                jumlah = '$jumlah',
                harga = '$harga',
                tanggal = '$tanggal'
            WHERE id = '$id'";
    
    return mysqli_query($conn, $sql);
}

// fungsi menghapus data
function delete_barang($conn, $id){
    $sql = "DELETE FROM tabel_barang Where id ='$id'";
    if (mysqli_query($conn, $sql)) {
        return "produk berhasil di hapus.";
    } else {
        return "gagal menghapus produk " . mysqli_error($conn,);
    }
}




// ambil data katagori dari tabel katagori
function ambil_kategori_list($conn) {
    return mysqli_query($conn, "SELECT * FROM tabel_katagori ORDER BY katagori ASC");
}

// menghitug jumlah barang 
function count_barang($conn, $filter_kategori = '', $search_keyword = '') {
    $sql = "SELECT COUNT(*) as total FROM tabel_barang WHERE 1";
    
    if (!empty($filter_kategori)) {
        $filter_kategori = mysqli_real_escape_string($conn, $filter_kategori);
        $sql .= " AND katagori = '$filter_kategori'";
    }

    if (!empty($search_keyword)) {
        $search_keyword = mysqli_real_escape_string($conn, $search_keyword);
        $sql .= " AND nama_barang LIKE '%$search_keyword%'";
    }

    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['total'];
}

// fungsi untuk ambil khusus katagori barang 
function ambil_barang_list($conn, $filter_kategori = '', $search_keyword = '', $start = 0, $limit = 10) {
    $sql = "SELECT * FROM tabel_barang WHERE 1";
    
    if (!empty($filter_kategori)) {
        $filter_kategori = mysqli_real_escape_string($conn, $filter_kategori);
        $sql .= " AND katagori = '$filter_kategori'";
    }

    if (!empty($search_keyword)) {
        $search_keyword = mysqli_real_escape_string($conn, $search_keyword);
        $sql .= " AND nama_barang LIKE '%$search_keyword%'";
    }

    $sql .= " ORDER BY id DESC LIMIT $start, $limit";
    return mysqli_query($conn, $sql);
}

?>